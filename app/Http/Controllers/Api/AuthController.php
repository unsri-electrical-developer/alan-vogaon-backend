<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\ApiController;
use App\Http\Controllers\Controller;
use App\Models\Admin;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends ApiController
{
    public function login(Request $request)
    {
        if (!auth('admin')->attempt($request->only('email', 'password')))
        {
            return $this->sendError(1, "Login gagal! Silahkan cek kembali email dan password", []);
        }

        $user = Admin::where('email', $request['email'])->firstOrFail();

        $token = $user->createToken(auth('admin')->user()->email, ['admin'])->plainTextToken;
        $data = auth('admin')->user();
        $data->access_token = $token;

        return $this->sendResponse(0, "Login berhasil", $data);
        
    }

    public function logout(Request $request)
    {
        $request->user()->currentAccessToken()->delete();

        return $this->sendResponse(0, "Logout berhasil", []);
    }

    public function tokenCheck(Request $request)
    {
        $check = Auth::check();
        $header = Auth::user($request->header('Authorization'));

        // return $header;
        if (!Auth::check()) {
            auth('sanctum')->user()->currentAccessToken()->delete();
            return $this->sendError(2, "Unauthorized.", (object) array());
        } else {
            $logged = Auth::user($request->header('Authorization'));
            $logged['access_token'] = $request->bearerToken();

            if ($header) {
                return  $this->sendResponse(0, 'Valid Token', $logged);
            } else {
                return  $this->sendResponse(2, 'Invalid Token');
            }
        }

    }
}
