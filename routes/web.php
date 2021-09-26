<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\BookController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\OrderController;

use App\Http\Controllers\Admin\AuthorController;
use App\Http\Controllers\Admin\BookController as AdminBookController;
use App\Http\Controllers\Admin\OrderController as AdminOrderController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\LoginController as AdminLoginController;
use App\Http\Controllers\Admin\HomeController;
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

Route::get('/', [BookController::class, 'index'])
    ->name('index');
Route::get('book/{book}', [BookController::class, 'show'])
    ->name('book.show');

# 会员区域
Route::middleware('auth')->group(function() {
        Route::get('cart', [CartController::class, 'index'])
        ->name('cart.index');
    Route::post('cart', [CartController::class, 'addToCart'])
        ->name('cart.add');
    Route::put('cart', [CartController::class, 'update'])
        ->name('cart.update');
    Route::get('cart/delete/{id}', [CartController::class, 'delete'])
        ->name('delete_book_from_cart');

    Route::post('order', [OrderController::class, 'store']);
    Route::get('order', [OrderController::class, 'index'])
        ->name('order');
});
Auth::routes();

# 管理员区域
Route::middleware('admin')
    ->prefix('admin')
    ->name('admin.')
    ->group(function() {
        Route::get('/', [HomeController::class, 'index']);

        Route::resource('author', AuthorController::class)
            ->except(['show']);
        Route::put('author', [AuthorController::class, 'index'])
            ->name('author.search');

        Route::resource('book', AdminBookController::class)
            ->except('show');
        Route::put('book', [AdminBookController::class, 'index'])
            ->name('book.search');

        Route::resource('user', UserController::class)
            ->except(['show']);
        Route::put('user', [UserController::class, 'index'])
            ->name('user.search');
            
        Route::get('order', [AdminOrderController::class, 'index'])
            ->name('order.index');
        Route::get('order/details/{order}', [AdminOrderController::class, 'details'])
            ->name('order.details');
        Route::delete('order/{order}', [AdminOrderController::class, 'destroy'])
            ->name('order.destroy');
        Route::put('order', [AdminOrderController::class, 'index'])
            ->name('order.search');
});
 # elfinder
 Route::middleware('admin')
    ->prefix('admin')
    ->group(function() {
        Route::get('/elfinder/popup', '\Barryvdh\Elfinder\ElfinderController@showPopup');
});
Route::get('/admin/login', [AdminLoginController::class, 'showLoginForm'])
    ->name('admin.login');
Route::post('/admin/login', [AdminLoginController::class, 'login']);
Route::post('/admin/logout', [AdminLoginController::class, 'logout'])
    ->name('admin.logout');
