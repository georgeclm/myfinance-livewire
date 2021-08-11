<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\RekeningApiController;
use App\Http\Controllers\TestApiController;
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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);
Route::get('/user', [AuthController::class, 'getCurrentUser']);
Route::post('/update', [AuthController::class, 'update']);
Route::get('/logout', [AuthController::class, 'logout']);




//get type_ie=3 articles where are welcome info
Route::get('/welcomeinfo', [TestApiController::class, 'welcomeinfo']);
Route::get('/recommendedarticles', [TestApiController::class, 'recommendedArticles']);
Route::get('/allarticles', [TestApiController::class, 'allArticles']);
