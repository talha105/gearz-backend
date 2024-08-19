<?php

use App\User;
use App\Jobs\SendEmailTest;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/




// Route::get('/', function () {
//     return view('welcome');
// });

Auth::routes();

  //  language change
  Route::get('change-language/{lang}' , function($lang){
    //   dd(session('locale'));

    App::setLocale($lang);

    session()->put('locale', $lang);

    if(session('locale') == 'ar'){
        $_SESSION['language'] = 'arabic' ;
    }else{
        $_SESSION['language'] = 'english' ;
    }
    // dd(session('locale'));
    return redirect()->back();
});


Route::get('/admin/login', 'HomeController@adminLogin')->name('home');
// Route::get('/user-login', 'HomeController@login')->name('userLogin');
// Route::post('/user-login', 'HomeController@userLogin')->name('userLogin');

// Route::get('/home', 'HomeController@index')->name('home');

Route::get('email-test' , function(){

    $user = new stdClass();
    $user->name = 'Saad';
    $user->email = 'saadanjum047@gmail.com';
    // #MAIL_USERNAME=_mainaccount@tasleeh.xyz

    $subject = "Testing Queue and emails";
    $body = "Testing Queue and emails";
    dispatch(new SendEmailTest($user , $subject , $body ));

});


Route::get('/create-base-admin', 'AdminController@makeBaseAdmin');
Route::get('/create-pages', 'AdminController@makePages');
Route::get('/email', function(){
    $msg = 'content';
    return view('emails.general' , compact('msg'));
});

// Route::get('admin-md' ,  function(){
//     return view('layouts.admin-md');
// } );
Route::get('admin/{path?}' , 'AdminController@dashboard' )->where('path', '^(?!.*api).*$[\/\w\.-]*')->middleware('auth');
Route::get('/{path?}' , 'MainController@home' )->where('path', '^(?!.*api).*$[\/\w\.-]*');
