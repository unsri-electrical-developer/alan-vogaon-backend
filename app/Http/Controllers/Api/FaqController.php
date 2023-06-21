<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\ApiController;
use App\Http\Controllers\Controller;
use App\Models\Faq;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class FaqController extends ApiController
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

    public function setFaq(Request $request)
    {
        $validator = $this->validateThis($request, [
            'faq' => 'required',
        ]);

        if ($validator->fails()) {
            return $this->sendError(1, 'Params not complete', $this->validationMessage($validator->errors()));
        }

        $faq_arr = [];

        foreach ($request->faq as $key => $faq) {
            if ($faq['pertanyaan'] !== null || $faq['jawaban'] !== null) {
                $faq_arr[$key]['pertanyaan'] = $faq['pertanyaan'];
                $faq_arr[$key]['jawaban'] = $faq['jawaban'];
                $faq_arr[$key]['created_at'] = Carbon::now();
                $faq_arr[$key]['updated_at'] = Carbon::now();
            }
        }

        Faq::whereNotNull('id')->delete();
        $res = Faq::insert($faq_arr);

        if (!$res) {
            $this->sendError(1, "Gagal menyimpan data!", []);
        }

        return $this->sendResponse(0, "Berhasil menyimpan data!", []);
    }

    public function getFaq(Request $request)
    {
        $faqs = Faq::all(['id', 'pertanyaan', 'jawaban', 'created_at']);

        return $this->sendResponse(0, "Sukses", $faqs);
    }
}
