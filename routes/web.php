<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Foundation\Auth\EmailVerificationRequest;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\HomeController;

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

Route::get('/home', [HomeController::class, 'index'])->name('home');
Route::get('/getUserData', [HomeController::class, 'returnAjaxData'])->name('getUserData');

Route::middleware(['auth', 'restrictRole'])->group( function() {

    Route::get('/dashboard', [ProductController::class, 'homePage']);
    Route::get('/getData', [ProductController::class, 'returnAjaxData'])->name('getData');
    Route::resource('products', ProductController::class);
});
