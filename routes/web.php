<?php

use Illuminate\Support\Facades\Route;
use App\Models\System;
use App\Models\Route as Routes;
use Illuminate\Support\Facades\Mail;

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
/*
Route::get('/enviar-email-teste', function () {
    try {
        $to = 'mayco_rolbuche@hotmail.com';

        Mail::raw('Teste de e-mail do Laravel', function ($message) use ($to) {
            $message->to($to)
                ->subject('Teste de e-mail do Laravel');
        });

        return 'E-mail de teste enviado para ' . $to;
    } catch (\Exception $e) {
        return 'Erro ao enviar o e-mail: ' . $e->getMessage();
    }
});*/

Route::get('/home', function () {
    return redirect('/');
});


Route::group(['namespace' => 'App\Http\Controllers'], function () {
    Route::get('/install', 'Data\InstallController@install')->name('install');

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

        Route::group(['prefix' => 'data'], function () {
            Route::get('/icons', 'Data\IconController@index')->name('icons');
        });

        try {
            $routes = Routes::all();
            $systems = System::all();
            $path = explode("/", request()->path());

            foreach ($systems as $system) {
                Route::group(['prefix' => $system->slug, 'middleware' => ['system']], function () use ($routes, $path, $system) {

                    Route::get('/', 'HomeController@dashboard')->name('system.' . $system->slug);

                    if ($path[0] == $system->slug) {
                        Route::group(['prefix' => 'me'], function () {
                            Route::get('/authorizations', 'Me\AuthorizationController@index')->name('me-authorizations');
                            Route::get('/authorizations/datatable', 'Me\AuthorizationController@datatable')->name('me-authorizations.datatable');
                            Route::get('/authorizations/{id}', 'Me\AuthorizationController@show')->where('id', '[0-9]+')->name('me-authorizations.show');
                            Route::put('/authorizations/{id}', 'Me\AuthorizationController@update')->where('id', '[0-9]+')->name('me-authorizations.update');

                            Route::get('/batches', 'Me\BatchController@index')->name('me-batches');
                            Route::get('/batches/datatable', 'Me\BatchController@datatable')->name('me-batches.datatable');
                            Route::get('/batches/{id}/pdf', 'Me\BatchController@pdf')->where('id', '[0-9]+')->name('me-batches.pdf');
                            Route::get('/batches/{id}', 'Me\BatchController@show')->where('id', '[0-9]+')->name('me-batches.show');
                            Route::delete('/batches/{id}', 'Me\BatchController@destroy')->where('id', '[0-9]+')->name('me-batches.destroy');
                        });

                        Route::get('/', 'HomeController@dashboard')->name('dashboard');

                        Route::group(['middleware' => ['access']], function () use ($routes) {
                            foreach ($routes as $route) {

                                //if (in_array("datatable", $route->resources)) {
                                Route::get($route->uri . '/datatable', $route->controller . '@datatable')->name($route->name . '.datatable');
                                //}
                                if (in_array("index", $route->resources)) {
                                    if (strpos($route->uri, "/{pid}/") !== false) {
                                        Route::get(str_replace("/{pid}/", "/", $route->uri), $route->controller . '@parent')->name($route->name);
                                        Route::get($route->uri, $route->controller . '@index')->name($route->name . ".index");
                                    } else {
                                        Route::get($route->uri, $route->controller . '@index')->name($route->name);
                                    }
                                }
                                if (in_array("create", $route->resources)) {
                                    Route::get($route->uri . '/create', $route->controller . '@create')->name($route->name . '.create');
                                }
                                if (in_array("store", $route->resources)) {
                                    Route::post($route->uri, $route->controller . '@store')->name($route->name . '.store');
                                }
                                if (in_array("show", $route->resources)) {
                                    Route::get($route->uri . '/{id}', $route->controller . '@show')->where('id', '[0-9]+')->name($route->name . '.show');
                                }
                                if (in_array("edit", $route->resources)) {
                                    Route::get($route->uri . '/{id}/edit', $route->controller . '@edit')->where('id', '[0-9]+')->name($route->name . '.edit');
                                }

                                if (in_array("update-all", $route->resources)) {
                                    Route::put($route->uri, $route->controller . '@update')->where('id', '[0-9]+')->name($route->name . '.update');
                                } elseif (in_array("update", $route->resources)) {
                                    Route::put($route->uri . '/{id}', $route->controller . '@update')->where('id', '[0-9]+')->name($route->name . '.update');
                                }

                                if (in_array("destroy", $route->resources)) {
                                    Route::delete($route->uri . '/{id}', $route->controller . '@destroy')->where('id', '[0-9]+')->name($route->name . '.destroy');
                                }
                            }
                        });
                    }
                });
            }
        } catch (\Exception $e) {
        }
    });
});
