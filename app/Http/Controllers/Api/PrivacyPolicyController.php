<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\ApiController;
use App\Http\Controllers\Controller;
use App\Models\PrivacyPolicy;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class PrivacyPolicyController extends ApiController
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

    public function getPrivacyPolicy(Request $request)
    {
        $privacy = PrivacyPolicy::first(['body']);

        if ($privacy) {
            return $this->sendResponse(0, "Sukses", [
                'privacy_policy' => $privacy->body
            ]);
        } else {
            return $this->sendResponse(0, "Data kosong!", [
                'privacy_policy' => ''
            ]);
        }
    }

    public function setPrivacyPolicy(Request $request)
    {
        $validator = $this->validateThis($request, [
            'privacy_policy' => 'required',
        ]);
        
        if ($validator->fails()) {
            return $this->sendError(1, 'Params not complete', $this->validationMessage($validator->errors()));
        }

        $result = PrivacyPolicy::updateOrCreate(
            ['privacy_policy_code' => 'privacy_policy'],
            ['body' => $request->privacy_policy ]
        );

        if ($result) {
            return $this->sendResponse(0, "Data berhasil disimpan!", []);
        } else {
            return $this->sendError(1, "Gagal menyimpan data!", []);
        }
    }
}
