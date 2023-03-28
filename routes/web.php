<?php

use App\Http\Controllers\AppInfoController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\Dashboard;
use App\Http\Controllers\ClientController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\PurchaseInvoiceController;
use App\Http\Controllers\PurchaseReturnController;
use App\Http\Controllers\SaleInvoiceController;
use App\Http\Controllers\SaleReturnController;
use App\Http\Controllers\AccountController;
use App\Http\Controllers\SupplierController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\WarehouseController;
use App\Http\Controllers\ReceiptController;
use Illuminate\Support\Facades\Route;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;

Route::group(
    [
        'prefix' => LaravelLocalization::setLocale(),
        'middleware' => [ 'localeSessionRedirect', 'localizationRedirect', 'localeViewPath' ]
    ], function(){
    Route::get('/login',[LoginController::class,'showLoginForm'])->name('login');
    Route::post('/login',[LoginController::class,'login'])->name('login');
    Route::post('/logout',[LoginController::class,'logout'])->name('logout');

    //Dashboard
    Route::get('/home',[Dashboard::class,'index'])->name('dashboard');
    //user
    Route::resource('/user', UserController::class);
    //client
    Route::resource('/client', ClientController::class);
    //supplier
    Route::resource('/supplier',SupplierController::class);
    //warehouse
    Route::resource('/warehouse', WarehouseController::class);
    //saleInvoice
    Route::resource('/saleInvoice', SaleInvoiceController::class);
    //purchaseInvoice
    Route::resource('/purchaseInvoice', PurchaseInvoiceController::class);
    //saleReturn
    Route::resource('/saleReturn', SaleReturnController::class);
    //purchaseReturn
    Route::resource('/purchaseReturn', PurchaseReturnController::class);
    //Product
    Route::resource('/product', ProductController::class);
    Route::post('/getProduct',[ProductController::class,'getProduct']);
    //category
    Route::resource('/category', CategoryController::class)->except(['show']);
    //receipt
    Route::resource('/receipt', ReceiptController::class);
    //account post route

    //account
    Route::resource('/account', AccountController::class);
    Route::post('/getMainAccount',[AccountController::class,'getMainAccount']);
    Route::post('/getSubAccount',[AccountController::class,'getSubAccount']);

    //App Info
    Route::group(['prefix' => '/App_info'],function ()
    {
        Route::get('/show/{id}',[AppInfoController::class,'edit']);
        Route::post('/update/{id}',[AppInfoController::class,'update']);
    });
});

