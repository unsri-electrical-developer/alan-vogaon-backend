<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\ApiController;
use App\Http\Controllers\Controller;
use App\Models\PaymentGateway;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class PaymentGatewayController extends ApiController
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
        $payment_gateways = PaymentGateway::latest()
            ->when($request->has('search'), function ($query) use ($request) {
                $query->where('pg_name', 'like', '%' . $request->search . '%');
            })
            ->get(['pg_name', 'pg_code', 'created_at']);

        return $this->sendResponse(0, "Sukses", $payment_gateways);
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
            'pg_name' => 'required'
        ]);
        
        if ($validator->fails()) {
            return $this->sendError(1, 'Params not complete', $this->validationMessage($validator->errors()));
        }
        
        $validated = $validator->validated();
        $pg_code = generateFiledCode('PG');
        $validated['pg_code'] = $pg_code;

        $result = PaymentGateway::create($validated);
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
        $pg = PaymentGateway::where('pg_code', $id)->first();
        
        if (!$pg) {
            return $this->sendError(1, "Data tidak ditemukan", []);
        }

        return $this->sendResponse(0, "Sukses", $pg);
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
            'pg_name' => 'required'
        ]);
        
        if ($validator->fails()) {
            return $this->sendError(1, 'Params not complete', $this->validationMessage($validator->errors()));
        }

        $pg = PaymentGateway::where('pg_code', $id)->first();
        
        if (!$pg) {
            return $this->sendError(1, "Data tidak ditemukan", []);
        }
        $pg->pg_name = $request->pg_name;

        $result = $pg->save();
        if ($result) {
            return $this->sendResponse(0, "Berhasil mengubah data!", []);
        } else {
            return $this->sendError(0, "Gagal mengubah data!", []);
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
        $pg = PaymentGateway::where('pg_code', $id)->first();
        
        if (!$pg) {
            return $this->sendError(1, "Data tidak ditemukan", []);
        }
        
        $result = $pg->delete();
        if ($result) {
            return $this->sendResponse(0, "Berhasil menghapus data!", []);
        } else {
            return $this->sendError(1, "Gagal menghapus data!", []);
        }
        
    }
}
