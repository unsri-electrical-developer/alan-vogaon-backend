<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\ApiController;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class TestController extends ApiController
{
     public function __construct()
    {
    }

    public function test ()
    {
      return response()->json([
            'message' => 'Hello World',
        ], 200);
    }

    public function validateThis($request, $rules = array())
    {
        return Validator::make($request->all(), $rules);
    }
}
