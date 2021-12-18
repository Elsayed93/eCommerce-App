<?php

use Illuminate\Support\Facades\Route;
use Modules\Admin\Http\Controllers\AdminController;

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


// Route::prefix('admin')->middleware(['auth:admin'])->group(function () {
//     Route::get('/', 'AdminController@index');
// });


Route::group(
    [
        'prefix' => LaravelLocalization::setLocale(),
        'middleware' => ['localeSessionRedirect', 'localizationRedirect', 'localeViewPath']
    ],
    function () { //...
        Route::group(['middleware' => 'auth:admin', 'prefix' => 'admin'], function () {

            // Route::view('/', 'admin');
            // Route::get('/', 'AdminController@index');
            Route::get('/', [AdminController::class, 'index']);
        });
    }
);
