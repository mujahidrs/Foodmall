<?php

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

Route::get('/', function () {
    return view('welcome');
});

/**
 * /home ---> GET
 * 
 */

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
Route::post('/addToCart', [App\Http\Controllers\OrderController::class, 'store'])->name('addToCart');
Route::get('/mycart', [App\Http\Controllers\CartController::class, 'index'])->name('mycart');
Route::post('/mycart/incrementProduct', [App\Http\Controllers\CartController::class, 'incrementProduct'])->name('mycart.incrementProduct');
Route::post('/mycart/decrementProduct', [App\Http\Controllers\CartController::class, 'decrementProduct'])->name('mycart.decrementProduct');
Route::get('/mycart/delete/{id}', [App\Http\Controllers\CartController::class, 'delete'])->name('mycart.delete');
Route::get('/mycart/deleteAll', [App\Http\Controllers\CartController::class, 'deleteAll'])->name('mycart.deleteAll');
Route::post('/mycart/changeAddress', [App\Http\Controllers\CartController::class, 'changeAddress'])->name('mycart.changeAddress');
Route::post('/mycart/checkout', [App\Http\Controllers\CartController::class, 'checkout'])->name('mycart.checkout');
Route::get('/profile', [App\Http\Controllers\ProfileController::class, 'index'])->name('profile');