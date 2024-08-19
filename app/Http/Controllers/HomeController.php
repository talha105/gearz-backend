<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

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

     public function adminLogin()
     {
        return view('auth.login');
     }
     public function login()
     {

        return view('main.login');
     }
     
     public function userLogin(Request $request)
     {

        dd($request->all());
        return view('main.login');
     }
    public function index()
    {
        // return view('home');
        // dd('s');
        return redirect('/admin/dashboard');
    }
}
