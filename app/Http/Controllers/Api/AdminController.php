<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\ApiController;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class AdminController extends ApiController
{
    public function getAdmin(Request $request)
    {
        $data = DB::table('admins')
            ->select(['admin_profile_pic', 'created_at', 'email', 'id', 'name', 'updated_at'])
            ->where('name', 'like', '%' . $request->search . '%')
            ->get();

        foreach ($data as $item) {
            if (!empty($item->admin_profile_pic)) {
                if (!filter_var($item->admin_profile_pic, FILTER_VALIDATE_URL)) {
                    $file_path = storage_path('app/public' . $item->admin_profile_pic);
                    if (file_exists($file_path)) {
                        $file_url = asset('storage' . $item->admin_profile_pic);
                        $item->admin_profile_pic = $file_url;
                    } else {
                        $item->admin_profile_pic = null;
                    }
                }
            } else {
                $item->img = null;
            }
        }

        return $this->sendResponse(0, 'Berhasil', $data);
    }

    public function getDetailAdmin($code)
    {
        $admin = DB::table('admins')->where('id', $code)->first();
        
        if (!empty($admin->admin_profile_pic)) {
                if (!filter_var($admin->admin_profile_pic, FILTER_VALIDATE_URL)) {
                    $file_path = storage_path('app/public' . $admin->admin_profile_pic);
                    if (file_exists($file_path)) {
                        $file_url = asset('storage' . $admin->admin_profile_pic);
                        $admin->admin_profile_pic = $file_url;
                    } else {
                        $admin->admin_profile_pic = null;
                    }
                }
            } else {
                $admin->img = null;
            }

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

            if (!empty($request->img)) {
                $data['admin_profile_pic'] = uploadFotoWithFileName($request->img, 'ADMIN', '/admins');
            }

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

            if (!str_contains($request->img, 'http') && !empty($request->img)) {
                $data['admin_profile_pic'] = uploadFotoWithFileName($request->img, 'ADMIN', '/admins');
            }

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
            $data = DB::table('admins')->where('id', $code)->delete();

            DB::commit();
            return $this->sendResponse(0, 'Berhasil', []);
        } catch (\Exception $e) {
            DB::rollBack();
            return $this->sendError(2, 'Gagal', $e->getMessage());
        }
    }
}
