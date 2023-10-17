<?php

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

Route::group(['namespace' => 'App\Http\Controllers'], function () {
    Route::group(['middleware' => ['guest']], function () {
        /**
         * Login Routes
         */
        Route::get('/login', 'LoginController@index')->name('login');
        Route::post('/login', 'LoginController@login')->name('login.auth');
    });

    Route::group(['middleware' => ['auth']], function () {
        Route::get('/', 'HomeController@index')->name('home');
        Route::get('/logout', 'LogoutController@index')->name('logout');
    });
});


Route::get('/home', function () {
    return redirect('/');
});
