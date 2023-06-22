<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\ApiController;
use App\Http\Controllers\Controller;
use App\Models\GamesVoucher;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;

class GamesVoucherController extends ApiController
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
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param string $game_code
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, $game_code)
    {
        DB::beginTransaction();

        try {
            $validator = $this->validateThis($request, [
                'data' => 'required|array',
                'data.*.redeem_code' => 'required',
                'data.*.status' => 'required',
                'data.*.game_item_code' => 'required',
            ]);

            if ($validator->fails()) {
                return $this->sendError(1, 'Params not complete', $this->validationMessage($validator->errors()));
            }

            $redeem_list = $request->data;

            foreach ($redeem_list as $key => $redeem) {
                $data = [
                    'game_code' => $game_code,
                    'game_item_code' => $redeem['game_item_code'],
                    'redeem_code' => $redeem['redeem_code'],
                    'status' => $redeem['status'],
                    'code' => generateFiledCode('GAMES-VOUCHER'),
                ];

                GamesVoucher::create($data);
            }

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
    public function show( $id)
    {
        $games_item = GamesVoucher::where('game_code', $id)->get();
        if (!$games_item) {
            return $this->sendError(1, "Data tidak ditemukan!", []);
        }
        return $this->sendResponse(0, "Sukses", $games_item);
    }

    /**
 * Update the specified resource in storage.
 *
 * @param  \Illuminate\Http\Request  $request
 * @param  string  $game_code
 * @return \Illuminate\Http\Response
 */
public function update(Request $request, $game_code)
{
    DB::beginTransaction();

    try {
        $validator = $this->validateThis($request, [
            'data' => 'required|array',
            'data.*.redeem_code' => 'required',
            'data.*.status' => 'required',
            'data.*.game_item_code' => 'required',
        ]);

        if ($validator->fails()) {
            return $this->sendError(1, 'Params not complete', $this->validationMessage($validator->errors()));
        }

        GamesVoucher::where('game_code', $game_code)->delete();

        $redeem_list = $request->data;

        foreach ($redeem_list as $key => $redeem) {
            $data = [
                'game_code' => $game_code,
                'code' => generateFiledCode('GAMES-VOUCHER'),
                'game_item_code' => $redeem['game_item_code'],
                'redeem_code' => $redeem['redeem_code'],
                'status' => $redeem['status'],
            ];

            GamesVoucher::create($data);
        }

        DB::commit();
        return $this->sendResponse(0, "Data updated successfully!", []);
    } catch (\Exception $e) {
        DB::rollBack();
        return $this->sendError(2, 'Failed to update data', $e->getMessage());
    }
}


  
}
