<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\ApiController;
use App\Http\Controllers\Controller;
use App\Models\Games;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class GamesController extends ApiController
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
    public function index(Request $request)
    {
        $games = Games::with('category:category_name,category_code')
            ->when($request->has('search'), function ($query) use ($request) {
                $query->where('title', 'like', '%' . $request->search . '%');
            })
            ->when($request->has('category_code'), function ($query) use ($request) {
                $query->where('category_code', $request->category_code);
            })
            ->get([
                'title',
                'code',
                'img',
                'category_code'
            ]);
        
        // Cek img url atau file
        foreach ($games as $item) {
            if (!filter_var($item->img, FILTER_VALIDATE_URL)) {
                $file_url = asset('storage' . $item->img);
                $item->img = $file_url;
            }
        }

        return $this->sendResponse(0, "Sukses", $games);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validator = $this->validateThis($request, [
            'img' => 'required',
            'title' => 'required',
            'category_code' => 'required'
        ]);
        
        if ($validator->fails()) {
            return $this->sendError(1, 'Params not complete', $this->validationMessage($validator->errors()));
        }
        
        $validated = $validator->validated();
        $game_code = generateFiledCode('GAMES');
        $validated['code'] = $game_code;

        $img_path = uploadFotoWithFileName($request->img, 'GAMES', '/games');
        $validated['img'] = $img_path;

        $result = Games::create($validated);
        return $this->sendResponse(0, "Sukses", []);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $game = Games::where('code', $id)->with('category:category_name,category_code')->first();
        
        if (!$game) {
            return $this->sendError(1, "Data tidak ditemukan", []);
        }

        if (!filter_var($game->img, FILTER_VALIDATE_URL)) {
            $file_url = asset('storage' . $game->img);
            $game->img = $file_url;
        }

        return $this->sendResponse(0, "Sukses", $game);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $validator = $this->validateThis($request, [
            'title' => 'required',
            'category_code' => 'required'
        ]);
        
        if ($validator->fails()) {
            return $this->sendError(1, 'Params not complete', $this->validationMessage($validator->errors()));
        }

        $game = Games::where('code', $id)->first();
        if (!$game) {
            return $this->sendError(1, "Data tidak ditemukan1", []);
        }
        
        $validated = $validator->validated();
        
        $result = $game->update($validated);
        if ($result) {
            return $this->sendResponse(0, "Berhasil mengubah data!", []);
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
    public function destroy($id)
    {
        $game = Games::where('code', $id)->first();
        
        if (!$game) {
            return $this->sendError(1, "Data tidak ditemukan", []);
        }
        
        $result = $game->delete();
        
        return $this->sendResponse(0, "Sukses", []);
    }
}
