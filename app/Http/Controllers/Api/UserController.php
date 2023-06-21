<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\ApiController;
use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class UserController extends ApiController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $users = User::latest()
            ->when($request->has('search'), function ($query) use ($request) {
                $query->where('name', 'like', '%' . $request->search . '%')
                ->orWhere('email', 'like', '%' . $request->search . '%')
                ->orWhere('no_telp', 'like', '%' . $request->search . '%');
            })
            ->get(['name', 'users_code', 'email', 'no_telp', 'users_profile_pic', 'created_at']);

        // Cek img url atau file

        foreach ($users as $item) {
            if (!empty($item->users_profile_pic)) {
                if (!filter_var($item->users_profile_pic, FILTER_VALIDATE_URL)) {
                    $file_path = storage_path('app/public' . $item->users_profile_pic);
                    if (file_exists($file_path)) {
                        $file_url = asset('storage' . $item->users_profile_pic);
                        $item->users_profile_pic = $file_url;
                    } else {
                        $item->users_profile_pic = null;
                    }
                    
                }
            } else {
                $item->users_profile_pic = null;
            }
            
        }

        return $this->sendResponse(0, "Sukses", $users);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $user = User::where('users_code', $id)->first([
            'name', 
            'email',
            'users_code', 
            'users_profile_pic', 
            'no_telp',
            'created_at'
        ]);
        
        if (!empty($user->users_profile_pic)) {
            if (!filter_var($user->users_profile_pic, FILTER_VALIDATE_URL)) {
                $file_path = storage_path('app/public' . $user->users_profile_pic);
                if (file_exists($file_path)) {
                    $file_url = asset('storage' . $user->users_profile_pic);
                    $user->users_profile_pic = $file_url;
                } else {
                    $user->users_profile_pic = null;
                    
                }
            }
        } else {
            $user->users_profile_pic = null;
        }

        return $this->sendResponse(0, "Sukses", $user);
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
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
