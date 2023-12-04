<?php

use App\Http\Controllers\FormController;
use App\Http\Controllers\HomeController;
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

Route::get('/', [HomeController::class, 'index']);

Route::get('/form', [FormController::class, 'index']);
Route::get('/shop', function () {
    return view('frontend.shop');
});

Route::get('/shop/detail', function () {
    return view('frontend.shop-detail');
});

Route::get('/shoping/cart', function () {
    return view('frontend.shoping-cart');
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
