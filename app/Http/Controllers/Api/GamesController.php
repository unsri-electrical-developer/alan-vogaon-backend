<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\ApiController;
use App\Http\Controllers\Controller;
use App\Models\Games;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
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
                $query->where('category_code', 'like', '%' . $request->category_code . '%');
            })
            ->latest()
            ->get([
                'title',
                'code as game_code',
                'img',
                'category_code'
            ]);

        // Cek img url atau file
        foreach ($games as $item) {
            if (!empty($item->img)) {
                if (!filter_var($item->img, FILTER_VALIDATE_URL)) {
                    $file_path = storage_path('app/public' . $item->img);
                    if (file_exists($file_path)) {
                        $file_url = asset('storage' . $item->img);
                        $item->img = $file_url;
                    } else {
                        $item->img = null;
                    }
                }
            } else {
                $item->img = null;
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

        DB::beginTransaction();

        try {
            $validator = $this->validateThis($request, [
                'img' => 'required',
                'title' => 'required',
                'category_code' => 'required',
                'kode_game' => 'required'
            ]);

            if ($validator->fails()) {
                return $this->sendError(1, 'Params not complete', $this->validationMessage($validator->errors()));
            }

            $validated = $validator->validated();
            // $game_code = generateFiledCode('GAMES');
            $validated['code'] = $request->kode_game;

            $img_path = uploadFotoWithFileName($request->img, 'GAMES', '/games');
            $validated['img'] = $img_path;

            $games_data = Games::create($validated);
            if (!$games_data) {
                return $this->sendError(0, "Gagal menambah data!", []);
            }

            $product_list = $request->productList;
            foreach ($product_list as $key => $product) {
                $data = [
                    'code' => generateFiledCode('GAMES-ITEM'),
                    'title' => $product['nama'],
                    'game_code' => $request['kode_game'],
                    'ag_code' => 'mobilelegends',
                    'digi_code' => 'mobile_legends',
                    'price' => $product['harga_member'],
                    'price_not_member' => $product['harga_non_member'],
                    'price_unipin' => 0,
                    'denomination_id' => $product['denomination_id'],
                    'isActive' => $product['status_produk'],
                    'from' => $product['asal_produk']
                ];

                DB::table('games_item')->insert($data);
            }

            $field_list = $request->fieldList;
            foreach ($field_list as $key => $field) {
                $data = [
                    'game_code' => $request['kode_game'],
                    'name' => $field['nama'],
                    'type' => $field['tipe']
                ];

                DB::table('fields')->insert($data);
            }

            // $games_item = [];
            // if ($request->has('games_item')) {
            //     $games_item = $request->games_item;
            // }

            // foreach ($games_item as $key => $game) {
            //     $game_code = generateFiledCode('GAMESITEM');
            //     $games_item[$key]['code'] = $game_code;
            //     $games_item[$key]['ag_code'] = 'mobilelegend'; // ??
            //     $games_item[$key]['isActive'] = true;
            //     $games_item[$key]['from'] = 'apigames'; // ??
            // }

            // $gi_result = $games_data->games_item()->createMany($games_item);

            // if (!$gi_result) {
            //     return $this->sendError(0, "Gagal menambah data!", []);
            // }

            DB::commit();
            return $this->sendResponse(0, "Berhasil menambah data!", []);
        } catch (\Exception $e) {
            DB::rollBack();
            return $this->sendError(2, 'Gagal menambahkan data', $e->getMessage());
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $game = Games::where('code', $id)
            ->with([
                'category:category_name,category_code',
                'games_item:code,title,isActive,from,denomination_id,price,price_not_member,game_code',
                'fields:name,type,game_code'
            ])
            ->first([
                'title',
                'code',
                'code as game_code',
                'img',
                'category_code',
                'created_at',

            ]);

        if (!$game) {
            return $this->sendError(1, "Data tidak ditemukan", []);
        }

        if (!empty($game->img)) {
            if (!filter_var($game->img, FILTER_VALIDATE_URL)) {
                $file_path = storage_path('app/public' . $game->img);
                if (file_exists($file_path)) {
                    $file_url = asset('storage' . $game->img);
                    $game->img = $file_url;
                } else {
                    $game->img = null;
                }
            }
        } else {
            $game->img = null;
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

        $game_data = Games::where('code', $id)->first();
        if (!$game_data) {
            return $this->sendError(1, "Data tidak ditemukan1", []);
        }

        $validated = $validator->validated();

        if ($request->has('img')) {
            if (Storage::exists('public' . $game_data->img)) {
                Storage::delete('public' . $game_data->img);
            }
            $img_path = uploadFotoWithFileName($request->img, 'GAMES', '/games');
            $validated['img'] = $img_path;
        }

        $games_item = [];
        if ($request->has('games_item')) {
            $games_item = $request->games_item;
        }

        foreach ($games_item as $key => $game) {
            $game_code = generateFiledCode('GAMESITEM');
            $games_item[$key]['code'] = $game_code;
            $games_item[$key]['ag_code'] = 'mobilelegend'; // ??
            $games_item[$key]['isActive'] = true;
            $games_item[$key]['from'] = 'apigames'; // ??
        }

        $result = $game_data->update($validated);

        if ($result) {
            $game_data->games_item()->delete();

            $gi_result = $game_data->games_item()->createMany($games_item);

            if (!$gi_result) {
                return $this->sendError(0, "Gagal mengubah data!", []);
            }
        } else {
            return $this->sendError(1, "Gagal mengubah data!", []);
        }
        return $this->sendResponse(0, "Berhasil mengubah data!", []);
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

        $game->games_item()->delete();

        $result = $game->delete();

        if (Storage::exists('public' . $game->img)) {
            Storage::delete('public' . $game->img);
        }

        if (!$result) {
            return $this->sendError(1, "Gagal menghapus data!", []);
        }

        return $this->sendResponse(0, "Berhasil menghapus data!", []);
    }
}
