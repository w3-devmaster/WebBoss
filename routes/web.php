<?php

use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\PagesController;
use App\Http\Controllers\SettingController;
use Illuminate\Support\Facades\Auth;
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

Route::get( '/', [PagesController::class, 'index'] )->name( 'index' );

Auth::routes();

Route::middleware( ['guest:web'] )->group( function ()
{

} );

Route::middleware( ['auth:web', 'PreventBackHistory'] )->group( function ()
{
    Route::view( '/home', 'pages.index' )->name( 'home' );
} );

Route::prefix( 'admin' )->name( 'admin.' )->group( function ()
{
    Route::middleware( ['guest:admin', 'PreventBackHistory'] )->group( function ()
    {
        Route::view( '/login', 'admin.login' )->name( 'login' );
        Route::post( '/check', [AdminController::class, 'check'] )->name( 'check' );
    } );

    Route::middleware( ['auth:admin', 'PreventBackHistory'] )->group( function ()
    {
        Route::view( '/', 'admin.index' )->name( 'index' );
        Route::view( '/dashboard', 'admin.index' )->name( 'dashboard' );
        Route::view( '/changepassword', 'admin.changepassword' )->name( 'changepassword' );
        Route::post( '/changepassword-take', [AdminController::class, 'changepassword'] )->name( 'changepassword-take' );
        Route::get( '/setting', [SettingController::class, 'index'] )->name( 'setting' );
        Route::post( '/setting', [SettingController::class, 'save_setting'] )->name( 'save-setting' );

        // Admin Logout
        Route::post( '/logout', [AdminController::class, 'logout'] )->name( 'logout' );
    } );

} );