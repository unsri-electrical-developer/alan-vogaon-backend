<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\ApiController;
use App\Http\Controllers\Controller;
use App\Models\SyaratKetentuan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class SyaratKetentuanController extends ApiController
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

    public function getSyaratKetentuan(Request $request)
    {
        $sk = SyaratKetentuan::first(['body']);

        if ($sk) {
            return $this->sendResponse(0, "Sukses", [
                'syarat_ketentuan' => $sk->body
            ]);
        } else {
            return $this->sendResponse(0, "Data kosong!", [
                'syarat_ketentuan' => ''
            ]);
        }
    }

    public function setSyaratKetentuan(Request $request)
    {
        $validator = $this->validateThis($request, [
            'syarat_ketentuan' => 'required',
        ]);
        
        if ($validator->fails()) {
            return $this->sendError(1, 'Params not complete', $this->validationMessage($validator->errors()));
        }

        $result = SyaratKetentuan::updateOrCreate(
            ['syarat_ketentuan_code' => 'syarat_ketentuan'],
            ['body' => $request->syarat_ketentuan ]
        );

        if ($result) {
            return $this->sendResponse(0, "Data berhasil disimpan!", []);
        } else {
            return $this->sendError(1, "Gagal menyimpan data!", []);
        }
    }
}
