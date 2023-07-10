<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\ApiController;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class AdminController extends ApiController
{
    public function getAdmin(Request $request)
    {
        $admin_id = Auth::user()->id;
        $data = DB::table('admins')
            ->select(['created_at', 'email', 'id', 'name', 'updated_at'])
            ->where('name', 'like', '%' . $request->search . '%')
            ->get();

        $data_send = [];

        foreach ($data as $key => $admin) {
            if ($admin->id != $admin_id) {
                array_push($data_send, $admin);
            }
        }

        return $this->sendResponse(0, 'Berhasil', $data_send);
    }

    public function getDetailAdmin($code)
    {
        $admin = DB::table('admins')
            ->where('id', $code)
            ->select(['created_at', 'email', 'id', 'name', 'updated_at', 'fa_set', 'fa_secret'])
            ->first();

        return $this->sendResponse(0, 'Berhasil', $admin);
    }

    public function addAdmin(Request $request)
    {
        DB::beginTransaction();
        try {
            $data = [
                'name' => $request->name,
                'email' => $request->email,
                'email_verified_at' => date('Y-m-d'),
                'password' => Hash::make($request->password),
                'created_at' => date('Y-m-d')
            ];

            $data = DB::table('admins')->insert($data);

            DB::commit();
            return $this->sendResponse(0, 'Berhasil', []);
        } catch (\Exception $e) {
            DB::rollBack();
            return $this->sendError(2, 'Gagal', $e->getMessage());
        }
    }

    public function editAdmin(Request $request)
    {
        DB::beginTransaction();

        try {
            $data = [
                'name' => $request->name,
                'email' => $request->email,
                'email_verified_at' => date('Y-m-d'),
                'updated_at' => date('Y-m-d')
            ];

            if (!empty($request->password)) {
                $data['password'] = Hash::make($request->password);
            }

            $data = DB::table('admins')->where('id', $request->id)->update($data);

            DB::commit();
            return $this->sendResponse(0, 'Berhasil', []);
        } catch (\Exception $e) {
            DB::rollBack();
            return $this->sendError(2, 'Gagal', $e->getMessage());
        }
    }

    public function deleteAdmin($code)
    {
        DB::beginTransaction();
        try {
            DB::table('admins')->where('id', $code)->delete();

            DB::commit();
            return $this->sendResponse(0, 'Berhasil', []);
        } catch (\Exception $e) {
            DB::rollBack();
            return $this->sendError(2, 'Gagal', $e->getMessage());
        }
    }

    public function getFABarcode()
    {
        $barcode = getFABarcode(Auth::user()->fa_secret);

        return $this->sendResponse(0, 'Berhasil', (object)['barcode' => $barcode]);
    }

    public function pairFABarcode(Request $request)
    {
        $barcode = pairFA($request->otp, Auth::user()->fa_secret);
        if ($barcode == "False") {
            return $this->sendError(2, 'Gagal', $barcode);
        }

        DB::table('admins')->where('id', Auth::user()->id)->update(['fa_set' => 1]);

        return $this->sendResponse(0, 'Berhasil', (object)['barcode' => $barcode]);
    }

    public function setMaintenanceMode(Request $request)
    {
        $status = $request->status;
        DB::table('about')->update(['maintenance_mode' => $status]);

        return $this->sendResponse(0, 'Berhasil', []);
    }
}
