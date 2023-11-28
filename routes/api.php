<?php

declare(strict_types=1);

use App\Http\Controllers\Security\AuthController;
use App\Http\Controllers\Security\RegistrationController;
use App\Http\Controllers\Url\UrlController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->group(function () {
    Route::apiResource('urls', UrlController::class)->name('*', 'urls');
    Route::get('logout', [AuthController::class, 'logout'])->name('logout');
});

Route::post('login', [AuthController::class, 'login'])->name('login');
Route::post('register', RegistrationController::class)->name('register');
