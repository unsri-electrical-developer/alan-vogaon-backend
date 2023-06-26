<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\ApiController;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class TestController extends ApiController
{
    public function __construct()
    {
    }

    public function getImage($folder = '', $img)
    {
        $file_name = $img;
        $storagePath  = Storage::disk('public')->getDriver()->getAdapter()->getPathPrefix();
        $fullPath = $storagePath . '/';
        if ($folder) {
            $fullPath .= $folder.'/';
        }
        $fullPath .= $file_name;
        
        return $this->sendResponseFile($fullPath);
    }

    public function test(Request $request)
    {
        $img = uploadFotoToGStorage($request->file, 'FOTO', 'test');
        // dd($img);
        return $this->sendResponse(200, 'Success', $img);
    }

    public function validateThis($request, $rules = array())
    {
        return Validator::make($request->all(), $rules);
    }
}
