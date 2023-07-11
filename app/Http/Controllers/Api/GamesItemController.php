<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\ApiController;
use App\Http\Controllers\Controller;
use App\Models\GamesItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class GamesItemController extends ApiController
{
  public function validateThis($request, $rules = array())
  {
    return Validator::make($request->all(), $rules);
  }

  public function validationMessage($validation)
  {
    $validate = collect($validation)->flatten();
    return $validate->values()->all();
  }

  /**
   * Display a listing of the resource.
   *
   * @return \Illuminate\Http\Response
   */
  public function index(Request $request, $game_code)
  {
    $games_items = GamesItem::where('game_code', $game_code)->latest()->get();

    return $this->sendResponse(0, "Sukses", $games_items);
  }

  /**
   * Store a newly created resource in storage.
   *
   * @param  \Illuminate\Http\Request  $request
   * @return \Illuminate\Http\Response
   */
  public function store(Request $request, $game_code)
  {
    $validator = $this->validateThis($request, [
      'title' => 'required',
      'price' => 'required',
    ]);

    if ($validator->fails()) {
      return $this->sendError(1, 'Params not complete', $this->validationMessage($validator->errors()));
    }

    $validated = $validator->validated();
    $game_code = generateFiledCode('GAMESITEM');
    $validated['code'] = $game_code;
    $validated['game_code'] = $request->game_code;
    $validated['ag_code'] = 'mobilelegend'; // ??
    $validated['isActive'] = true;
    $validated['from'] = 'apigames'; // ??

    $result = GamesItem::create($validated);
    if ($result) {
      return $this->sendResponse(0, "Sukses", []);
    } else {
      return $this->sendError(1, "Gagal menambah data!", []);
    }
  }

  /**
   * Display the specified resource.
   *
   * @param  int  $id
   * @return \Illuminate\Http\Response
   */
  public function show($game_code, $id)
  {
    $games_item = GamesItem::where('code', $id)->first();
    if (!$games_item) {
      return $this->sendError(1, "Data tidak ditemukan!", []);
    }
    return $this->sendResponse(0, "Sukses", $games_item);
  }

  /**
   * Update the specified resource in storage.
   *
   * @param  \Illuminate\Http\Request  $request
   * @param  int  $id
   * @return \Illuminate\Http\Response
   */
  public function update(Request $request, $game_code, $id)
  {
    $validator = $this->validateThis($request, [
      'title' => 'required',
      'price' => 'required'
    ]);

    if ($validator->fails()) {
      return $this->sendError(1, 'Params not complete', $this->validationMessage($validator->errors()));
    }
    $validated = $validator->validated();

    $games_item = GamesItem::where('code', $id)->first();

    if (!$games_item) {
      return $this->sendError(1, "Data tidak ditemukan!", []);
    }
    $result = $games_item->update($validated);
    if ($result) {
      return $this->sendResponse(0, "Sukses mengubah data!", []);
    } else {
      return $this->sendError(1, "Gagal mengubah data!", []);
    }
  }

  /**
   * Remove the specified resource from storage.
   *
   * @param  int  $id
   * @return \Illuminate\Http\Response
   */
  public function destroy($game_code, $id)
  {
    $game_item = GamesItem::where('code', $id)->first();

    if (!$game_item) {
      return $this->sendError(1, "Data tidak ditemukan", []);
    }

    $result = $game_item->delete();
    if ($result) {
      return $this->sendResponse(0, "Sukses menghapus data!", []);
    } else {
      return $this->sendError(1, "Gagal menghapus data!", []);
    }
  }
}
