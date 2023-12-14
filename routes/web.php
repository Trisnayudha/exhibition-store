<?php

use App\Http\Controllers\CompanyController;
use App\Http\Controllers\FormController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\MiningDirectory\MediaController;
use App\Http\Controllers\MiningDirectory\NewsController;
use App\Http\Controllers\MiningDirectory\ProductsController;
use App\Http\Controllers\MiningDirectory\ProjectController;
use App\Http\Controllers\MiningDirectory\RepresentativeController;
use App\Http\Controllers\PromotionalController;
use App\Http\Controllers\TestController;
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


Route::post('/test', [TestController::class, 'test']);
Route::post('/postPersonal', [CompanyController::class, 'postPersonal']);
Route::post('/postCompany', [CompanyController::class, 'postCompany']);
Route::post('/postGeneral', [CompanyController::class, 'postGeneral']);

//Logger
Route::get('/representative/log', [RepresentativeController::class, 'log']);
Route::get('/media/log', [MediaController::class, 'log']);
Route::get('/product/log', [ProductsController::class, 'log']);
Route::get('/project/log', [ProjectController::class, 'log']);
Route::get('/news/log', [NewsController::class, 'log']);


//Crud
Route::resource('representative', RepresentativeController::class);
Route::resource('media', MediaController::class);
Route::resource('product', ProductsController::class);
Route::resource('project', ProjectController::class);
Route::resource('news', NewsController::class);

Route::post('promotional/advertisement', [PromotionalController::class, 'advertisement']);
Route::post('promotional/sosmed', [PromotionalController::class, 'sosmed']);
Route::delete('promotional/{id}', [PromotionalController::class, 'delete']);
