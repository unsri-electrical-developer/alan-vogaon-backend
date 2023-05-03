<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\ApiController;
use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class CategoryController extends ApiController
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
    public function index()
    {
        $categories = Category::latest()->get([
            'category_name',
            'category_code'
        ]);

        return $this->sendResponse(0, "Sukses", $categories);
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
            'category_name' => 'required'
        ]);
        
        if ($validator->fails()) {
            return $this->sendError(1, 'Params not complete', $this->validationMessage($validator->errors()));
        }
        
        $validated = $validator->validated();
        $category_code = generateFiledCode('CAT');
        $validated['category_code'] = $category_code;

        $result = Category::create($validated);
        return $this->sendResponse(0, "Sukses", []);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $category = Category::where('category_code', $id)->first();
        
        if (!$category) {
            return $this->sendError(1, "Data tidak ditemukan", []);
        }

        return $this->sendResponse(0, "Sukses", $category);
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
            'category_name' => 'required'
        ]);
        
        if ($validator->fails()) {
            return $this->sendError(1, 'Params not complete', $this->validationMessage($validator->errors()));
        }

        $category = Category::where('category_code', $id)->first();
        
        if (!$category) {
            return $this->sendError(1, "Data tidak ditemukan", []);
        }
        $category->category_name = $request->category_name;

        $result = $category->save();
        return $this->sendResponse(0, "Sukses", []);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $category = Category::where('category_code', $id)->first();
        
        if (!$category) {
            return $this->sendError(1, "Data tidak ditemukan", []);
        }
        
        $result = $category->delete();
        
        return $this->sendResponse(0, "Sukses", []);
    }
}
