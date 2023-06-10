<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\VerificationController;
use App\Http\Controllers\Api\resetPasswordController;


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

Route::middleware('auth:sanctum','verified')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout'])->middleware('auth:sanctum');

Route::get('/email/resend', [VerificationController::class, 'resend'])->middleware('auth:sanctum')->name('verification.resend');
Route::get('/email/verify/{id}/{hash}', [VerificationController::class, 'verify'])->middleware('auth:sanctum')->name('verification.verify');

Route::post('/forget-password', [resetPasswordController::class, 'forgotPassword']);
Route::post('/reset-password', [resetPasswordController::class, 'reset'])->name('password.reset');
