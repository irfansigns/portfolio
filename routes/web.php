<?php
use Inertia\Inertia;
use App\Models\Product;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\PayOrderController;

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

// Route::get('/', function () {
//     return Inertia::render('Welcome');
// });
Route::get('/', [ProductController::class, 'index'])->name('basePath');
Route::resource('products',ProductController::class);
// Route::get('products/detail/{id}', [ProductController::class, 'detail'])->name('detail');
Route::get('/product/watch/{product}', [ProductController::class, 'watch'])->name('product.watch');
Route::get('/product/addCart/{id}', [ProductController::class, 'addToCart'])->name('product.addCart');
// Route::get('/product/lessOne/{id}', [ProductController::class, 'lessOne'])->name('product.lessOne')->middleware('auth');
Route::get('/product/lessOne/{id}', [ProductController::class, 'lessOne'])->name('product.lessOne');
Route::get('/product/cart', [ProductController::class, 'showCart'])->name('product.cart');
Route::get('/product/order', [ProductController::class, 'storeOrder'])->name('product.sorder');
Route::get('/shop', [ProductController::class, 'shop'])->name('shop');
Route::get('/shop/category/{id}', [ProductController::class, 'shopCategory'])->name('shop.cat');
Route::post('/updateUser', [ProductController::class, 'updateUser'])->name('updateUser');

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

//      Admin Routes
Route::get('/admin',[AdminController::class,'index'])->name('admin')->middleware('admin.auth');
Route::get('/adminlogin',[AdminController::class,'showLogin'])->name('admin.login');
Route::post('/adminlogged',[AdminController::class,'login'])->name('admin.logged');

// Route::get('/delProduct/{$id}',[ProductController::class,'delProduct'])->name('delProduct');
Route::get('/delProduct{id}', [ProductController::class,'delProduct'])->name('delProduct');
Route::get('/testEffect',[ProductController::class,'testEffect'])->name('testEffect');
Route::get('/description{id}',[ProductController::class,'description'])->name('prod.des');
Route::get('/test{id}',[ProductController::class,'testFunction'])->name('testRoute');
Route::get('pay',[PayOrderController::class,'store']);



