<?php

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\ProfileController;
use App\Http\Controllers\Api\resetPasswordController;
use App\Http\Controllers\Api\VerificationController;
use App\Http\Controllers\Api\ProductController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;


/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/


Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout'])->middleware('auth:sanctum');

Route::get('/email/resend', [VerificationController::class, 'resend'])->middleware('auth:sanctum')->name('verification.resend');
Route::get('/email/verify/{id}/{hash}', [VerificationController::class, 'verify'])->middleware('auth:sanctum')->name('verification.verify');

Route::post('/forgot-password', [resetPasswordController::class, 'forgotPassword']);
Route::post('/reset-password', [resetPasswordController::class, 'reset'])->name('password.reset');

Route::middleware(['auth:sanctum'])->group( function (){
    Route::get('/profile', function (Request $request){
        return $request->user();
    });
    Route::post('/profile', [ProfileController::class, 'update']);
    Route::resource('products', ProductController::class)->middleware('restrictRole');
    Route::post('products/{id}', [ProductController::class, 'update'])->middleware('restrictRole');

    Route::post('assign-user/{product_id}', [ProductController::class, 'assignToUser'])->middleware('restrictRole');
    Route::get('get-user-product/{user_id}', [ProductController::class, 'getUserProducts']);

});

