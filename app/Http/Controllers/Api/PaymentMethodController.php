<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\ApiController;
use App\Http\Controllers\Controller;
use App\Models\PaymentGateway;
use App\Models\PaymentMethod;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class PaymentMethodController extends ApiController
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
        $payment_methods = PaymentMethod::latest()
        ->when($request->has('search'), function ($query) use ($request) {
            $query->where('pm_name', 'like', '%' . $request->search . '%');
        })
        ->get(['pm_title', 'pm_code', 'pm_logo', 'from', 'isActive', 'created_at']);

        foreach ($payment_methods as $item) {
            if (!filter_var($item->pm_logo, FILTER_VALIDATE_URL)) {
                $file_url = asset('storage' . $item->pm_logo);
                $item->pm_logo = $file_url;
            }
        }

        return $this->sendResponse(0, "Sukses", $payment_methods);
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
            'pm_title' => 'required',
            'pm_code' => 'required|unique:payment_method,pm_code',
            'pm_logo' => 'required',
            'from' => 'required'
        ]);
        
        if ($validator->fails()) {
            return $this->sendError(1, 'Params not complete', $this->validationMessage($validator->errors()));
        }

        $pg = PaymentGateway::where('pg_code', $request->from)->first();
        if (!$pg) {
            return $this->sendError(1, "Kode payment gateway yang dipilih tidak ada!", []);
        }
        
        $validated = $validator->validated();
        // $pm_code = generateFiledCode('PM');
        // $validated['pm_code'] = $pm_code;

        $img_path = uploadFotoWithFileName($request->pm_logo, 'PM', '/payment_method');
        $validated['pm_logo'] = $img_path;

        $validated['from'] = $request->from;
        $validated['isActive'] = true;

        $result = PaymentMethod::create($validated);
        if ($result) {
            return $this->sendResponse(0, "Berhasil menambah data!", []);
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
    public function show($id)
    {
        $payment_method = PaymentMethod::where('pm_code', $id)->first();
        
        if (!$payment_method) {
            return $this->sendError(1, "Data tidak ditemukan", []);
        }

        if (!filter_var($payment_method->pm_logo, FILTER_VALIDATE_URL)) {
            $file_url = asset('storage' . $payment_method->pm_logo);
            $payment_method->pm_logo = $file_url;
        }

        return $this->sendResponse(0, "Sukses", $payment_method);
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
            'pm_title' => 'required',
            'pm_logo' => 'required',
            'from' => 'required',
        ]);
        
        if ($validator->fails()) {
            return $this->sendError(1, 'Params not complete', $this->validationMessage($validator->errors()));
        }

        $payment_method = PaymentMethod::where('pm_code', $id)->first();

        if (!$payment_method) {
            return $this->sendError(1, "Data tidak ditemukan!", []);   
        }

        $pg = PaymentGateway::where('pg_code', $request->from)->first();
        if (!$pg) {
            return $this->sendError(1, "Kode payment gateway yang dipilih tidak ada!", []);
        }
        
        $validated = $validator->validated();
        // $pm_code = generateFiledCode('PM');
        // $validated['pm_code'] = $pm_code;

        $img_path = uploadFotoWithFileName($request->pm_logo, 'PM', '/payment_method');
        $validated['pm_logo'] = $img_path;

        $validated['from'] = $request->from;

        $result = $payment_method->update($validated);

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
        $payment_method = PaymentMethod::where('pm_code', $id)->first();
        
        if (!$payment_method) {
            return $this->sendError(1, "Data tidak ditemukan", []);
        }
        
        $result = $payment_method->delete();
        if ($result) {
            return $this->sendResponse(0, "Berhasil menghapus data!", []);
        } else {
            return $this->sendError(1, "Gagal menghapus data!", []);
        }
    }
}
