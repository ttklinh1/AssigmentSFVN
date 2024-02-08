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

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
Route::get('/category', [App\Http\Controllers\CategoryController::class, 'index'])->name('category');
Route::get('/category/create', [App\Http\Controllers\CategoryController::class, 'create'])->name('category-create');
Route::post('/category/create', [App\Http\Controllers\CategoryController::class, 'postCreate'])->name('category-post-create');
Route::get('/product', [App\Http\Controllers\ProductController::class, 'index'])->name('product');
Route::get('/product/create', [App\Http\Controllers\ProductController::class, 'create'])->name('product-create');
Route::post('/product/create', [App\Http\Controllers\ProductController::class, 'postCreate'])->name('product-post-create');
Route::get('/order', [App\Http\Controllers\OrderController::class, 'index'])->name('order');
Route::get('/order/create', [App\Http\Controllers\OrderController::class, 'create'])->name('order-create');
Route::post('/order/create', [App\Http\Controllers\OrderController::class, 'postCreate'])->name('order-post-create');
Route::get('/order/edit/{id}', [App\Http\Controllers\OrderController::class, 'edit'])->name('order-edit');
Route::post('/order/update', [App\Http\Controllers\OrderController::class, 'update'])->name('order-update');
Route::delete('/order/delete/{id}', [App\Http\Controllers\OrderController::class, 'delete'])->name('order-delete');
