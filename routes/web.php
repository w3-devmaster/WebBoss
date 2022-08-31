<?php

use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\ManageController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\PagesController;
use App\Http\Controllers\PDFController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\SettingController;
use App\Http\Controllers\SlideController;
use App\Http\Controllers\User\UserController;
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

Route::get( '/cart', [PagesController::class, 'cart'] )->name( 'cart' );
Route::post( '/store-cart', [PagesController::class, 'store_cart'] )->name( 'store_cart' );
Route::post( '/edit-cart', [PagesController::class, 'edit_cart'] )->name( 'edit_cart' );
Route::post( '/del-cart', [PagesController::class, 'del_cart'] )->name( 'del_cart' );
Route::post( '/clear-cart', [PagesController::class, 'clear_cart'] )->name( 'clear_cart' );

Route::get( '/product', [PagesController::class, 'product'] )->name( 'product' );
Route::get( '/product-list/{id}', [PagesController::class, 'product_list'] )->name( 'product-list' );
Route::get( '/product/{order}/{asc}', [PagesController::class, 'product'] )->name( 'product-order' );
Route::get( '/category/{id}', [PagesController::class, 'category'] )->name( 'category' );
Route::get( '/category/{id}/{order}/{asc}', [PagesController::class, 'category'] )->name( 'category-order' );

Route::post( '/register-payment', [PagesController::class, 'register_payment'] )->name( 'register-payment' );
Route::post( '/login-payment', [PagesController::class, 'login_payment'] )->name( 'login-payment' );
Route::post( '/search-product', [PagesController::class, 'search_product'] )->name( 'search-product' );

Route::view( '/how-to-buy', 'pages.how-to-buy' )->name( 'how-to-buy' );
Route::view( '/how-to-payment', 'pages.how-to-payment' )->name( 'how-to-payment' );
Route::view( '/about', 'pages.about' )->name( 'about' );
Route::view( '/contact', 'pages.contact' )->name( 'contact' );
Route::view( '/privacy-policy', 'pages.privacy-policy' )->name( 'privacy-policy' );
Route::view( '/refund-policy', 'pages.refund-policy' )->name( 'refund-policy' );
Route::view( '/product-policy', 'pages.product-policy' )->name( 'product-policy' );

Route::middleware( ['auth:web', 'PreventBackHistory'] )->group( function ()
{
    Route::post( '/order-create', [PagesController::class, 'order_create'] )->name( 'order-create' );
} );

Route::prefix( 'user' )->name( 'user.' )->group( function ()
{
    Route::middleware( ['auth:web', 'PreventBackHistory'] )->group( function ()
    {
        // Route::view( '/home', 'pages.index' )->name( 'home' );
        Route::get( '/', [UserController::class, 'index'] )->name( 'index' );
        Route::post( '/update-user', [UserController::class, 'update_user'] )->name( 'update-user' );
        Route::view( '/changepassword', 'user.changepassword' )->name( 'changepassword' );
        Route::post( '/changepassword-take', [UserController::class, 'changepassword'] )->name( 'changepassword-take' );
        Route::view( '/payment', 'user.payment' )->name( 'payment' );
        Route::post( '/payment', [UserController::class, 'payment'] )->name( 'payment-add' );
        Route::get( '/billing', [UserController::class, 'billing'] )->name( 'billing' );
        Route::get( '/billing-info/{id}', [UserController::class, 'billing_info'] )->name( 'billing-info' );
        Route::get( '/receipt/{id}', [PDFController::class, 'receipt_user'] )->name( 'receipt' );
    } );
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
        Route::get( '/', [AdminController::class, 'index'] )->name( 'index' );
        Route::get( '/dashboard', [AdminController::class, 'dashboard'] )->name( 'dashboard' );
        Route::view( '/changepassword', 'admin.changepassword' )->name( 'changepassword' );
        Route::post( '/changepassword-take', [AdminController::class, 'changepassword'] )->name( 'changepassword-take' );
        Route::get( '/setting', [SettingController::class, 'index'] )->name( 'setting' );
        Route::post( '/setting', [SettingController::class, 'save_setting'] )->name( 'save-setting' );
        Route::resource( '/category', CategoryController::class, ['name' => 'category'] );
        Route::resource( '/product', ProductController::class, ['name' => 'product'] );
        Route::get( '/customers', [AdminController::class, 'customers'] )->name( 'customers' );
        Route::get( '/customer/{id}', [AdminController::class, 'customer'] )->name( 'customer' );

        Route::get( '/order-list', [AdminController::class, 'order_list'] )->name( 'order-list' );
        Route::get( '/order-success', [AdminController::class, 'order_success'] )->name( 'order-success' );
        Route::get( '/order/{order}', [AdminController::class, 'order_view'] )->name( 'order' );
        Route::post( '/update-order/{order}', [AdminController::class, 'update_order'] )->name( 'update-order' );
        Route::post( '/update-discount/{order}', [AdminController::class, 'update_discount'] )->name( 'update-discount' );
        Route::post( '/update-send/{order}', [AdminController::class, 'update_send'] )->name( 'update-send' );

        Route::get( '/receipt/{id}', [PDFController::class, 'receipt'] )->name( 'receipt' );

        Route::resource( '/slide', SlideController::class, ['name' => 'slide'] );

        Route::middleware( 'IsOwner' )->group( function ()
        {
            Route::resource( '/manage', ManageController::class, ['name' => 'manage'] );
            Route::view( '/test', 'admin.pages.test' )->name( 'test' );
            Route::post( '/test', [AdminController::class, 'create_test_data'] )->name( 'test-create' );
            Route::post( '/reset', [AdminController::class, 'reset_data'] )->name( 'reset' );
        } );

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