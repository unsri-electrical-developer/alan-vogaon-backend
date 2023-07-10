<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\ApiController;
use App\Http\Controllers\Controller;
use App\Models\Admin;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class ProfileController extends ApiController
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

    public function editProfile(Request $request)
    {
        $id_admin = auth()->user()->id;

        $validator = $this->validateThis($request, [
            'name' => 'required',
            'email' => 'required|unique:users,email,' . auth()->user()->id,
        ]);
        
        if ($validator->fails()) {
            return $this->sendError(1, 'Params not complete', $this->validationMessage($validator->errors()));
        }

        $validated = $validator->validated();

        $admin = Admin::find($id_admin);

        if ($request->has('admin_profile_pic')) {
            if (!empty($request->admin_profile_pic)) {
                if (Storage::exists('public' . $admin->admin_profile_pic)) {
                    Storage::delete('public' . $admin->admin_profile_pic);
                }
                $img_path = uploadFotoWithFileName($request->img, 'ADMIN', '/admin_profile_pic');
                $validated['admin_profile_pic'] = $img_path;
            } else {
                $validated['admin_profile_pic'] = null;
            }
            
        }

        if ($request->has('password')) {
            if (!empty($request->password)) {
                $hashed = Hash::make($request->password);
                $validated['password'] = $hashed;
            }
        }

        $result = $admin->update($validated);

        if ($result) {
            return $this->sendResponse(0, "Berhasil mengubah data!", []);
        } else {
            return $this->sendError(1, "Gagal mengubah data!", []);
        }
    }

    public function getProfile(Request $request)
    {
        $admin_id = auth()->user()->id;

        $admin = Admin::find($admin_id, ['name', 'email', 'admin_profile_pic', 'fa_set', 'fa_secret', 'role']);

        if (!empty($admin->admin_profile_pic)) {
            if (!filter_var($admin->admin_profile_pic, FILTER_VALIDATE_URL)) {
                // $file_path = storage_path('app/public' . $admin->admin_profile_pic);
                // if (file_exists($file_path)) {
                    // $file_url = asset('storage' . $admin->admin_profile_pic);
                    $file_url = env('ADMIN_DOMAIN') . $admin->admin_profile_pic;
                    $admin->admin_profile_pic = $file_url;
                // } else {
                //     $admin->admin_profile_pic = null;
                    
                // }
            }
        } else {
            $admin->admin_profile_pic = null;
        }
        $admin['users_type'] = $admin->role;

        return $this->sendResponse(0, "Sukses", $admin);

    }
}
