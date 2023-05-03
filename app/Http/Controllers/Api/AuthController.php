<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\ApiController;
use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends ApiController
{
    public function login(Request $request)
    {
        if (!Auth::attempt($request->only('email', 'password')))
        {
            return $this->sendError(1, "Login gagal! Silahkan cek kembali email dan password", []);
        }

        $user = User::where('email', $request['email'])->firstOrFail();

        $token = $user->createToken(Auth::user()->email)->plainTextToken;
        $data = Auth::user();
        $data->access_token = $token;

        return $this->sendResponse(0, "Login berhasil", $data);
        
    }

    public function logout(Request $request)
    {
        $request->user()->currentAccessToken()->delete();

        return $this->sendResponse(0, "Logout berhasil", []);
    }
}
