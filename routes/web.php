<?php

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

Route::get('/', 'BookController@index')
    ->name('index');
Route::get('book/{book}', 'BookController@show')
    ->name('book.show');

# 会员区域
Route::middleware('auth')->group(function() {
        Route::get('cart', 'CartController@index')
        ->name('cart.index');
    Route::post('cart', 'CartController@addToCart')
        ->name('cart.add');
    Route::put('cart', 'CartController@update')
        ->name('cart.update');
    Route::get('cart/delete/{id}', 'CartController@delete')
        ->name('delete_book_from_cart');

    Route::post('order', 'OrderController@store');
    Route::get('order', 'OrderController@index')
        ->name('order');
});
Auth::routes();

# 管理员区域
Route::middleware('admin')
    ->prefix('admin')
    ->namespace('Admin')
    ->name('admin.')
    ->group(function() {
        Route::get('/', 'HomeController@index');

        Route::resource('author', 'AuthorController')
            ->except(['show']);
        Route::put('author', 'AuthorController@index')
            ->name('author.search');

        Route::resource('book', 'BookController')
            ->except('show');
        Route::put('book', 'BookController@index')
            ->name('book.search');

        Route::resource('user', 'UserController')
            ->except(['show']);
        Route::put('user', 'UserController@index')
            ->name('user.search');
            
        Route::get('order', 'OrderController@index')
            ->name('order.index');
        Route::get('order/details/{order}', 'OrderController@details')
            ->name('order.details');
        Route::delete('order/{order}', 'OrderController@destroy')
            ->name('order.destroy');
        Route::put('order', 'OrderController@index')
            ->name('order.search');
});
 # elfinder
 Route::middleware('admin')
    ->prefix('admin')
    ->group(function() {
        Route::get('/elfinder/popup', '\Barryvdh\Elfinder\ElfinderController@showPopup');
});
Route::get('/admin/login', 'Admin\LoginController@showLoginForm')
    ->name('admin.login');
Route::post('/admin/login', 'Admin\LoginController@login');
Route::post('/admin/logout', 'Admin\LoginController@logout')
    ->name('admin.logout');
