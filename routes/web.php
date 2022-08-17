<?php

use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\CategoryController;
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
    Route::view( '/how-to-buy', 'pages.how-to-buy' )->name( 'how-to-buy' );
    Route::view( '/how-to-payment', 'pages.how-to-payment' )->name( 'how-to-payment' );
    Route::view( '/about', 'pages.about' )->name( 'about' );
    Route::view( '/contact', 'pages.contact' )->name( 'contact' );
    Route::view( '/privacy-policy', 'pages.privacy-policy' )->name( 'privacy-policy' );
    Route::view( '/refund-policy', 'pages.refund-policy' )->name( 'refund-policy' );
    Route::view( '/product-policy', 'pages.product-policy' )->name( 'product-policy' );
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
        Route::resource( '/category', CategoryController::class, ['name' => 'category'] );

        Route::prefix( 'setting' )->name( 'setting.' )->group( function ()
        {
            // Bank Account
            Route::get( '/bank', [SettingController::class, 'bank'] )->name( 'bank' );
            Route::post( '/bank', [SettingController::class, 'bank_exec'] )->name( 'bank-exec' );
            Route::delete( '/bank', [SettingController::class, 'bank_delete'] )->name( 'bank-delete' );

            // Pages
            Route::get( '/how-to-buy', [SettingController::class, 'how_to_buy'] )->name( 'how-to-buy' );
            Route::get( '/how-to-payment', [SettingController::class, 'how_to_payment'] )->name( 'how-to-payment' );
            Route::get( '/about', [SettingController::class, 'about'] )->name( 'about' );
            Route::get( '/contact', [SettingController::class, 'contact'] )->name( 'contact' );
            Route::get( '/privacy-policy', [SettingController::class, 'privacy_policy'] )->name( 'privacy-policy' );
            Route::get( '/refund-policy', [SettingController::class, 'refund_policy'] )->name( 'refund-policy' );
            Route::get( '/product-policy', [SettingController::class, 'product_policy'] )->name( 'product-policy' );

            Route::post( '/how-to-buy', [SettingController::class, 'how_to_buy_exec'] )->name( 'how-to-buy-exec' );
            Route::post( '/how-to-payment', [SettingController::class, 'how_to_payment_exec'] )->name( 'how-to-payment-exec' );
            Route::post( '/about', [SettingController::class, 'about_exec'] )->name( 'about-exec' );
            Route::post( '/contact', [SettingController::class, 'contact_exec'] )->name( 'contact-exec' );
            Route::post( '/privacy-policy', [SettingController::class, 'privacy_policy_exec'] )->name( 'privacy-policy-exec' );
            Route::post( '/refund-policy', [SettingController::class, 'refund_policy_exec'] )->name( 'refund-policy-exec' );
            Route::post( '/product-policy', [SettingController::class, 'product_policy_exec'] )->name( 'product-policy-exec' );
        } );

        // Admin Logout
        Route::post( '/logout', [AdminController::class, 'logout'] )->name( 'logout' );
    } );

} );