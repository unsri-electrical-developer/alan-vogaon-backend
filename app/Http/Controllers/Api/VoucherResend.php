<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Controllers\ApiController;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Mail;
use App\Mail\ResendVoucherCode;

class VoucherResend extends ApiController
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

    public function resendByEmail(Request $request)
    {
        $validator = $this->validateThis(
            $request,
            [
                'order_id' => 'required',
            ]
        );

        if ($validator->fails()) {
            return $this->sendError(1, 'Params not complete', $this->validationMessage($validator->errors()));
        }

        $order_id = $request->order_id;
        $transaction_detail = DB::table('transaction_detail')->where('transaction_code', $order_id)->get();
        $transaction = DB::table('transaction')->where('transaction_code', $order_id)->first();

        if (empty($transaction_detail) || empty($transaction)) {
            return $this->sendError(2, 'Riwayat transaksi tidak ditemukan!');
        }

        $user = DB::table('users')->where('users_code', $transaction->users_code)->first();

        if (!empty($user)) {
            $email = $transaction->email;
            $name = $user->name;
        } else {
            $email = $transaction->email;
            $str_email = explode('@', $email);
            $name = $str_email[0];
        }

        $redeem_codes_all = [];
        foreach ($transaction_detail as $detail) {
            $game_item = DB::table('games_item')->where('code', $detail->item_code)->first();

            $redeem_codes = $detail->redeem_code;
            if ($redeem_codes && strpos($redeem_codes, ',') !== false) {
                $redeem_codes_individual = explode(',', $redeem_codes);
                $redeem_codes = $redeem_codes_individual;
            } else {
                $redeem_codes = [$redeem_codes];
            }

            $game = DB::table('games')->where('code', $game_item->game_code)->first();
            $redeem_codes_all[] = [
                'game' => $game->title,
                'title' => $game_item->title,
                'redeem_codes' => $redeem_codes
            ];
        }
        $data = [
            'name' => $name,
            'redeem_codes' => $redeem_codes_all
        ];

        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            return $this->sendError(3, 'Alamat email tidak valid!');
        }

        try {
            Mail::to($email)->send(new ResendVoucherCode($data));
        } catch (\Exception $e) {
            return $this->sendError(
                3,
                'Gagal!',
                ['success' => false, 'msg' => $e->getMessage()]
            );
        }

        return $this->sendResponse(
            0,
            'Berhasil!',
            ['success' => true, 'msg' => 'Email kode redeem voucher berhasil dikirimkan!']
        );
    }
}
