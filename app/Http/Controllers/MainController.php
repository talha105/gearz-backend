<?php

namespace App\Http\Controllers;

use App\Page;
use Illuminate\Http\Request;

class MainController extends Controller
{
    

    public function home(){
        // dd(session('locale'));    
        $page = Page::where('slug' , 'logo')->first();
        return view('main.home' , compact('page'));
    }
}
