<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\ApiController;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PromoController extends ApiController
{
    public function getPromo(Request $request)
    {
        $data = DB::table('vouchers')->get();

        return $this->sendResponse(0, 'Berhasil', $data);
    }

    public function getDetailPromo($code)
    {
        $data = DB::table('vouchers')->where('vouchers_code', $code)->first();
        $pm = DB::table('payment_method')->where('status', 1)->get();
        foreach ($pm as $key => $value) {
            $value->status = 0;
            if (str_contains($data->payment_method, $value->pm_code)) {
                $value->status = 1;
            }
        }
        $data->payment_method = $pm;

        return $this->sendResponse(0, 'Berhasil', $data);
    }

    public function addPromo(Request $request)
    {
        $data = [
            'vouchers_code' => generateFiledCode('VC'),
            'vouchers_title' => $request->title,
            'vouchers_description' => $request->description,
            'vouchers_detail_code' => generateFiledCode('DT'),
            'vouchers_redeem_code' => $request->redeem_code,
            'voucher_discount' => $request->discount,
            'voucher_discount_max' => $request->discount_max,
            'con_payment_method' => $request->con_payment_method,
            'voucher_start' => $request->start,
            'voucher_end' => $request->end,
            'isActive' => 1
        ];
        if ($request->con_payment_method) {
            $pm = $request->payment_method;
            foreach ($pm as $key => $value) {
                if ($key == 0) {
                    $data['payment_method'] = $value['pm_code'];
                } else {
                    $data['payment_method'] .= ',' . $value['pm_code'];
                }
            }
        }
        $data = DB::table('vouchers')->insert($data);

        return $this->sendResponse(0, 'Berhasil', []);
    }

    public function editPromo(Request $request)
    {
        $data = [
            'vouchers_title' => $request->title,
            'vouchers_description' => $request->description,
            'vouchers_detail_code' => generateFiledCode('DT'),
            'vouchers_redeem_code' => $request->redeem_code,
            'voucher_discount' => $request->discount,
            'voucher_discount_max' => $request->discount_max,
            'con_payment_method' => $request->con_payment_method,
            'voucher_start' => $request->start,
            'voucher_end' => $request->end
        ];
        if ($request->con_payment_method) {
            $pm = $request->payment_method;
            $count = 0;
            foreach ($pm as $key => $value) {
                if ($value['status']) {
                    if ($count == 0) {
                        $data['payment_method'] = $value['pm_code'];
                        $count++;
                    } else {
                        $data['payment_method'] .= ',' . $value['pm_code'];
                        $count++;
                    }
                }
            }
        }
        $data = DB::table('vouchers')->where('vouchers_code', $request->vouchers_code)->update($data);

        return $this->sendResponse(0, 'Berhasil', []);
    }

    public function deletePromo($code)
    {
        $data = DB::table('vouchers')->where('vouchers_code', $code)->delete();

        return $this->sendResponse(0, 'Berhasil', []);
    }

    public function updateStatusPromo(Request $request)
    {
        DB::table('vouchers')->where('vouchers_code', $request->voucher_code)->update(['isActive' => $request->isActive]);

        return $this->sendResponse(0, 'Berhasil', []);
    }
}
