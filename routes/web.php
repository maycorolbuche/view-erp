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
        Route::get('/login', 'Auth\LoginController@index')->name('login');
        Route::post('/login', 'Auth\LoginController@login')->name('login.auth');

        Route::get('password/reset', 'Auth\ForgotPasswordController@showLinkRequestForm')->name('password.request');
        Route::get('password/email', function () {
            return redirect('password/reset');
        });
        Route::post('password/email', 'Auth\ForgotPasswordController@sendResetLinkEmail')->name('password.email');
        Route::get('password/reset/{token}', 'Auth\ResetPasswordController@showResetForm')->name('password.token');
        Route::post('password/reset', 'Auth\ResetPasswordController@reset')->name('password.reset');
    });

    Route::group(['middleware' => ['auth']], function () {
        Route::get('/', 'HomeController@index')->name('home');
        Route::get('/logout', 'Auth\LogoutController@index')->name('logout');

        Route::group(['prefix' => '{system}', 'middleware' => ['system']], function () {
            Route::get('/', 'HomeController@dashboard')->name('dashboard');

            Route::group(['middleware' => ['access']], function () {
                Route::get('/profile', 'HomeController@dashboard');
                Route::get('/systems', 'HomeController@dashboard');
                Route::post('/systems', 'HomeController@dashboard');
                Route::get('/profile/as', 'HomeController@dashboard');
                Route::get('/systems/ds', 'HomeController@dashboard');
                Route::post('/systems/as', 'HomeController@dashboard');
                Route::post('/ADS/as', 'HomeController@dashboard');
            });
        });
    });
});


Route::get('/home', function () {
    return redirect('/');
});
