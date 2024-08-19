<?php

namespace App\Http\Controllers;

use App\Page;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminController extends Controller
{
    public function dashboard(){

        $page = Page::where('slug' , 'logo')->first();

        $user = auth()->user();
        if($user){
            $tokenobj = Auth::user()->createToken('name');
            $token = $tokenobj->accessToken;
        }
        return view('layouts.admin-md' , compact('page','token'));
        // return view('layouts.admin');
    }

    public function makeBaseAdmin()
    {
        $user = User::create([
            'name' => 'Admin',
            'email' => 'admin@admin.com',
            'type' => 'super-admin',
            'password' => \Hash::make(123456),
        ]);

        if($user){
            echo "Good to GO";
        }
    }
    public function makePages()
    {
        Page::query()->delete();

        Page::create([
            'name' => 'Contact us',
            'slug' => 'contact-us',
        ]);

        Page::create([
            'name' => 'Contact ud details',
            'slug' => 'contact-us-details',
        ]);

        Page::create([
            'name' => 'Privacy Policy',
            'slug' => 'privacy-policy',
        ]);

        Page::create([
            'name' => 'Terms And Condition',
            'slug' => 'terms-and-condition',
        ]);

        Page::create([
            'name' => 'Logo',
            'slug' => 'logo',
        ]);

        Page::create([
            'name' => 'Splash Screen Image',
            'slug' => 'splash-screen',
        ]);

        Page::create([
            'name' => 'Login Screen Image',
            'slug' => 'login-screen',
        ]);

        Page::create([
            'name' => 'Register Screen Image',
            'slug' => 'register-screen',
        ]);

        Page::create([
            'name' => 'Listing Default',
            'slug' => 'listing-default-image',
        ]);

        Page::create([
            'name' => 'Image Sizes',
            'slug' => 'image-sizes',
        ]);

        echo "Good to GO";

    }
}
