<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\RekeningApiController;
use App\Http\Controllers\TestApiController;
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

// Route::resource('rekenings', RekeningApiController::class);
Route::post('register', [AuthController::class, 'register']);
Route::post('login', [AuthController::class, 'login']);
Route::get('rekenings', [RekeningApiController::class, 'index']);
Route::get('/welcomeinfo/', [TestApiController::class, 'welcomeinfo']);
// Route::get('rekenings/{rekening}', [RekeningApiController::class, 'show']);
Route::get('rekenings/search/{name}', [RekeningApiController::class, 'search']);

// Protected Routes
Route::group(['middleware' => 'auth:sanctum'], function () {
    Route::post('rekenings', [RekeningApiController::class, 'store']);
    Route::put('rekenings/{rekening}/update', [RekeningApiController::class, 'update']);
    Route::delete('rekenings/{rekening}', [RekeningApiController::class, 'destroy']);
    Route::post('logout', [AuthController::class, 'logout']);
});
