<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\CategoryApiController;
use App\Http\Controllers\RekeningApiController;
use App\Http\Controllers\TestApiController;
use App\Http\Controllers\TransactionApiController;
use App\Http\Controllers\UserApiController;
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



Route::middleware('auth:api')->group(function () {
    Route::get('/user', function () {
        return auth()->user();
    });
    Route::get('/logout', [AuthController::class, 'logout']);
    Route::get('/partial', [UserApiController::class, 'partial']);
    Route::post('/rekenings', [RekeningApiController::class, 'store']);
    Route::post('/rekenings/{rekening}', [RekeningApiController::class, 'update']);
    Route::get('/jenisuang/{jenisuang}/{rekening}', [RekeningApiController::class, 'detail']);
    Route::post('/rekenings/{rekening}/delete', [RekeningApiController::class, 'destroy']);
    Route::post('/rekenings/{rekening}/adjust', [RekeningApiController::class, 'adjust']);
    Route::get('/jenis', [UserApiController::class, 'jenis']);
    Route::get('/categories/{category}', [CategoryApiController::class, 'detail']);
    Route::get('/category_masuks/{category_masuk}', [CategoryApiController::class, 'detailMasuk']);
    Route::post('/transactions', [TransactionApiController::class, 'store']);
    Route::get('/categories', [CategoryApiController::class, 'index']);
    Route::get('/category_masuks', [CategoryApiController::class, 'indexMasuk']);
    Route::get('/transactions/{jenisuang}', [TransactionApiController::class, 'detail']);
    Route::get('/transactions/{jenisuang}/all', [TransactionApiController::class, 'detailAll']);
});
Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);
Route::post('/update', [AuthController::class, 'update']);


//get type_ie=3 articles where are welcome info
Route::get('/welcomeinfo', [TestApiController::class, 'welcomeinfo']);
Route::get('/recommendedarticles', [TestApiController::class, 'recommendedArticles']);
Route::get('/allarticles', [TestApiController::class, 'allArticles']);

Route::fallback(function () {
    return response()->error('Invalid Route', 404);
});
