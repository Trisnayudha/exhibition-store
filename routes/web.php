<?php

use App\Http\Controllers\CompanyController;
use App\Http\Controllers\EventPass\AdditionalController;
use App\Http\Controllers\EventPass\DelegateController;
use App\Http\Controllers\EventPass\ExhibitorController;
use App\Http\Controllers\EventPass\MiningController;
use App\Http\Controllers\EventPass\WorkingController;
use App\Http\Controllers\ExhibitionCartController;
use App\Http\Controllers\ExhibitionController;
use App\Http\Controllers\FormController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\InvoiceController;
use App\Http\Controllers\MiningDirectory\MediaController;
use App\Http\Controllers\MiningDirectory\NewsController;
use App\Http\Controllers\MiningDirectory\ProductsController;
use App\Http\Controllers\MiningDirectory\ProjectController;
use App\Http\Controllers\MiningDirectory\RepresentativeController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\PromotionalController;
use App\Http\Controllers\TestController;
use App\Http\Controllers\WebScrapingController;
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

Route::get('/scrape', [WebScrapingController::class, 'scrape']);

Route::get('/', [HomeController::class, 'index']);

Route::get('test', function () {
    return view('email');
});
Route::get('/form', [FormController::class, 'index']);

Route::get('/travel-information', function () {
    return view('frontend.travel-information.travel');
});
Route::get('/faq', function () {
    return view('frontend.faq.faq');
});

Route::get('invoice', [InvoiceController::class, 'index'])->name('invoice');
Route::get('invoice/detail/', [InvoiceController::class, 'summary']);
Route::get('dl/invoice/', [InvoiceController::class, 'downloadInvoice']);
Route::post('payment/request', [PaymentController::class, 'payment']);

Route::get('create/invoice', [PaymentController::class, 'create']);
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
Route::get('/delegate/log', [DelegateController::class, 'log']);
Route::get('/exhibitor/log', [ExhibitorController::class, 'log']);
Route::get('/working/log', [WorkingController::class, 'log']);
Route::get('/mining/log', [MiningController::class, 'log']);
Route::get('/additional/log', [AdditionalController::class, 'log']);

//Crud
Route::resource('representative', RepresentativeController::class);
Route::resource('media', MediaController::class);
Route::resource('product', ProductsController::class);
Route::resource('project', ProjectController::class);
Route::resource('news', NewsController::class);
Route::resource('delegate', DelegateController::class);
Route::resource('exhibitor', ExhibitorController::class);
Route::post('exhibitor/additional', [ExhibitorController::class, 'storeAdditional']);
Route::resource('working', WorkingController::class);
Route::resource('mining', MiningController::class);
Route::resource('additional', AdditionalController::class);

Route::post('promotional/advertisement', [PromotionalController::class, 'advertisement']);
Route::post('promotional/sosmed', [PromotionalController::class, 'sosmed']);
Route::delete('promotional/{id}', [PromotionalController::class, 'delete']);

Route::post('cart', [ExhibitionCartController::class, 'store']);
Route::post('cart-exhibition', [ExhibitionCartController::class, 'storeExhibition']);
Route::get('cart', [ExhibitionCartController::class, 'getData']);
Route::get('cart-count', [ExhibitionCartController::class, 'getCount']);
Route::delete('cart-item/{id}', [ExhibitionCartController::class, 'destroyDelegate']);
Route::delete('cart-item-exhibition/{id}', [ExhibitionCartController::class, 'destroyExhibition']);
Route::post('cart/change', [ExhibitionCartController::class, 'changeQuantity']);

Route::post('sticker', [ExhibitionController::class, 'storeSticker']);

//Exhibition
Route::post('pic', [ExhibitionController::class, 'storePic']);
