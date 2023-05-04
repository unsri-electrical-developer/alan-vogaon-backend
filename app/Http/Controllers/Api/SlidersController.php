<?php

namespace App\Http\Controllers\Api;
use App\Http\Controllers\ApiController;
use App\Http\Controllers\Controller;
use App\Models\Games;
use App\Models\Sliders;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class SlidersController extends ApiController
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
        $sliders = Sliders::latest()->get();

        foreach ($sliders as $item) {
            if (!filter_var($item->image, FILTER_VALIDATE_URL)) {
                $file_url = asset('storage' . $item->image);
                $item->image = $file_url;
            }
        }

        return $this->sendResponse(0, "Sukses", $sliders);
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
            'image' => 'required'
        ]);
        
        if ($validator->fails()) {
            return $this->sendError(1, 'Params not complete', $this->validationMessage($validator->errors()));
        }

        $validated = $validator->validated();
        
        $img_path = uploadFotoWithFileName($request->image, 'SLIDERS', '/sliders');
        $validated['image'] = $img_path;

        $result = Sliders::create($validated);
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
        $slider = Sliders::find($id);
        
        if (!$slider) {
            return $this->sendError(1, "Data tidak ditemukan", []);
        }

        if (!filter_var($slider->image, FILTER_VALIDATE_URL)) {
            $file_url = asset('storage' . $slider->image);
            $slider->image = $file_url;
        }

        return $this->sendResponse(0, "Sukses", $slider);
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
            'image' => 'required'
        ]);
        
        if ($validator->fails()) {
            return $this->sendError(1, 'Params not complete', $this->validationMessage($validator->errors()));
        }

        $slider = Sliders::find($id);
        if (!$slider) {
            return $this->sendError(1, "Data tidak ditemukan", []);
        }

        if (Storage::exists('public' . $slider->image)) {
            Storage::delete('public' . $slider->image);
        }

        $img_path = uploadFotoWithFileName($request->image, 'SLIDERS', '/sliders');

        $slider->image = $img_path;

        $slider->save();
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
        $slider = Sliders::where('id', $id)->first();
        
        if (!$slider) {
            return $this->sendError(1, "Data tidak ditemukan", []);
        }
        
        $slider->delete();

        if (Storage::exists('public' . $slider->image)) {
            Storage::delete('public' . $slider->image);
        }
        
        return $this->sendResponse(0, "Sukses", []);
    }
}
