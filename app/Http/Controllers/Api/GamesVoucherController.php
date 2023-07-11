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
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $games_items = GamesVoucher::latest()->get();

        return $this->sendResponse(0, "Sukses", $games_items);
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
        ]);

        if ($validator->fails()) {
            return $this->sendError(1, 'Params not complete', $this->validationMessage($validator->errors()));
        }

        $redeem_list = $request->data;

        foreach ($redeem_list as $key => $redeems) {
            foreach ($redeems as $redeem) {
                $data = [
                    'game_code' => $game_code,
                    'item_code' => $key,
                    'redeem_code' => $redeem['redeem_code'],
                    'voucher_status' => $redeem['voucher_status'],
                ];

                GamesVoucher::create($data);
            }
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
        $gamesVouchers = GamesVoucher::where('code', $id)
                ->first();

        
        if (!$gamesVouchers ) {
            return $this->sendError(1, "Data tidak ditemukan!", []);
        }
        return $this->sendResponse(0, "Sukses", $gamesVouchers );
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
        ]);

        if ($validator->fails()) {
            return $this->sendError(1, 'Params not complete', $this->validationMessage($validator->errors()));
        }

        GamesVoucher::where('game_code', $game_code)->delete();

        $redeem_list = $request->data;

        foreach ($redeem_list as $item_code => $redeems) {
            foreach ($redeems as $redeem) {
                $data = [
                    'game_code' => $game_code,
                    'item_code' => $item_code,
                    'redeem_code' => $redeem['redeem_code'],
                    'voucher_status' => $redeem['voucher_status'],
                ];

                GamesVoucher::create($data);
            }
        }
        DB::commit();
        return $this->sendResponse(0, "Data updated successfully!", []);
    } catch (\Exception $e) {
        DB::rollBack();
        return $this->sendError(2, 'Failed to update data', $e->getMessage());
    }
}


  
}
