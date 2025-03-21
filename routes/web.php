<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ImageController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\AdminProductController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\GuestOrderController;
use Illuminate\Support\Facades\Mail;



/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/


// Authentication routes, login, register, logout
Route::get('login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('login', [AuthController::class, 'login']);
Route::get('register', [AuthController::class, 'showRegistrationForm'])->name('register');
Route::post('register', [AuthController::class, 'register']);
Route::post('logout', [AuthController::class, 'logout'])->name('logout');


// 
Route::get('/', function () {
    return view('layouts/app');
})->name('app');


//admin routes
Route::group(['middleware' => ['auth', 'admin']], function () {
    Route::get('/admin/adminDashboard', [AdminController::class, 'index'])->name('admin.adminDashboard');
    Route::get('/admin/orders', [AdminController::class, 'manageOrders'])->name('admin.orders');
    Route::get('/admin/products', [AdminController::class, 'manageProducts'])->name('admin.products');
    Route::get('/admin/products/create', [AdminProductController::class, 'create'])->name('admin.products.create');
    Route::post('/admin/products/store', [AdminProductController::class, 'store'])->name('admin.products.store');
    Route::get('/admin/products/{product}/edit', [AdminProductController::class, 'edit'])->name('admin.products.edit');
    Route::put('/admin/products/{product}', [AdminProductController::class, 'update'])->name('admin.products.update');
    Route::delete('/admin/products/{product}', [AdminProductController::class, 'destroy'])->name('admin.products.destroy');
});



//free routes without authentication
//product routes
Route::get('/', [ProductController::class, 'index'])->name('home');
Route::get('/products', [ProductController::class, 'index'])->name('products.index');
Route::get('/products/{product}', [ProductController::class, 'show'])->name('products.show');
Route::get('/search', [ProductController::class, 'searchProduct'])->name('products.search');


Route::post('/cart/add', [CartController::class, 'add'])->name('cart.add');
Route::get('/cart/count', [CartController::class, 'getCartCount'])->name('cart.count');
Route::post('/cart/clear', [CartController::class, 'clear'])->name('cart.clear');
Route::delete('/cart/{id}', [CartController::class, 'destroy'])->name('cart.destroy');

Route::get('/order', [GuestOrderController::class, 'showOrderForm'])->name('order.show');


Route::middleware('web')->group(function () {
    Route::post('/order/store', [GuestOrderController::class, 'store'])->name('order.store');
    Route::get('/cart', [CartController::class, 'show'])->name('cart.show');
});
