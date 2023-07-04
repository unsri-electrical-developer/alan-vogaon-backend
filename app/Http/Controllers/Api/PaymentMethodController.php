<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\ApiController;
use App\Http\Controllers\Controller;
use App\Models\PaymentGateway;
use App\Models\PaymentMethod;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
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
            $query->where('pm_title', 'like', '%' . $request->search . '%');
        })
        ->when($request->has('static'), function ($query) use ($request) {
            $query->where('status', 1);
        })
        ->get(['pm_title', 'pm_code', 'pm_logo', 'from', 'status', 'min_order', 'fee', 'created_at']);

        foreach ($payment_methods as $item) {
            if (!filter_var($item->pm_logo, FILTER_VALIDATE_URL)) {
                $file_path = storage_path('app/public' . $item->pm_logo);
                if (file_exists($file_path)) {
                    // $file_url = asset('storage' . $item->pm_logo);
                    $file_url = env('ADMIN_DOMAIN') .  $item->pm_logo;
                    $item->pm_logo = $file_url;
                } else {
                    $item->pm_logo = null;
                }
            }
            if ($request->has('static')) {
                $item->status = 0;
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
            'from' => 'required',
            'min_order' => 'required',
            'fee' => 'required',
        ]);
        
        if ($validator->fails()) {
            return $this->sendError(1, 'Params not complete', $this->validationMessage($validator->errors()));
        }

        $pg = PaymentGateway::where('pg_code', $request->from)->first();
        if (!$pg) {
            return $this->sendError(1, "Gagal menambah data!", ["Kode payment gateway yang dipilih tidak ada!"]);
        }
        
        $validated = $validator->validated();
        // $pm_code = generateFiledCode('PM');
        // $validated['pm_code'] = $pm_code;

        $img_path = uploadFotoWithFileName($request->pm_logo, 'PM', '/payment_method');
        $validated['pm_logo'] = $img_path;

        $validated['from'] = $request->from;
        $validated['status'] = 1;

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
            // $file_url = asset('storage' . $payment_method->pm_logo);
            $file_url = env('ADMIN_DOMAIN') . $payment_method->pm_logo;
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
            'pm_code' => 'required',
            'min_order' => 'required',
            'fee' => 'required',
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

        if (Storage::exists('public' . $payment_method->pm_logo)) {
            Storage::delete('public' . $payment_method->pm_logo);
        }

        $img_path = uploadFotoWithFileName($request->pm_logo, 'PM', '/payment_method');
        $validated['pm_logo'] = $img_path;

        $validated['from'] = $request->from;

        $result = $payment_method->update($validated);

        if ($result) {
            return $this->sendResponse(0, "Berhasil mengubah data!", $validated);
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

        if (Storage::exists('public' . $payment_method->pm_logo)) {
            Storage::delete('public' . $payment_method->pm_logo);
        }

        if ($result) {
            return $this->sendResponse(0, "Berhasil menghapus data!", []);
        } else {
            return $this->sendError(1, "Gagal menghapus data!", []);
        }
    }

    public function togglePaymentMethod(Request $request, $pm_code)
    {
        $validator = $this->validateThis($request, [
            'status' => 'required'
        ]);
        
        if ($validator->fails()) {
            return $this->sendError(1, 'Params not complete', $this->validationMessage($validator->errors()));
        }

        $payment_method = PaymentMethod::where('pm_code', $pm_code)->first();
        if (!$payment_method) {
            return $this->sendError(1, "Data tidak ditemukan!", []);
        }

        $result = $payment_method->update(['status' => $request->status]);
        if ($result) {
            $data = [
                'pm_code' => $pm_code,
                'status' => $request->status
            ];
            return $this->sendResponse(0, "Berhasil mengubah status!", $data);
        } else {
            $data = [
                'pm_code' => $pm_code,
                'status' => $payment_method->status
            ];
            return $this->sendError(1, "Gagal mengubah status!", $data);
        }
    }
}
