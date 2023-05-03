<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Redirect;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        // $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        return view('home');
    }

    public function noRoute()
    {
        // dd(date('Y-m-d H:i:s'));
        return response()->json([
            'message' => 'no route and no API found with those values',
        ], 400);
    }

    public function notAuth()
    {
        return response()->json([
            'message' => 'Not Authenticate.',
        ], 401);
    }

    public function notFound()
    {
        return response()->json([
            'message' => 'Not Found.',
        ], 404);
    }

    public function redirect()
    {
        // dd(env('ZOOM_JWT_API_KEY'));
        // return getSlug(substr('Lorem ipsum dolor sit amet consectetur adipisicing elit. Provident ut dolor necessitatibus culpa, dignissimos amet illo veniam eveniet ullam nemo. Cum autem deleniti in quibusdam adipisci recusandae, est reiciendis aliquam.', 0, 199));
        return Redirect::to('https://www.vogaon.com/');
    }
}
