<?php

use App\Http\Controllers\ProductController;
use App\Http\Controllers\TransactionController;
use App\Http\Controllers\UserController;
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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::prefix('user')->group(function(){
    Route::post('/register', [UserController::class, 'register']);
    Route::post('/login', [UserController::class, 'login']);
});


Route::middleware('auth:api')->group( function () {

    Route::prefix('user')->group(function(){
        Route::get('/', [UserController::class, 'show']);
        Route::get('/{id}', [UserController::class, 'read']);
        Route::post('/update/{id}', [UserController::class, 'update']);
        Route::delete('/{id}', [UserController::class, 'delete']);
        Route::post('/change-foto/{id}', [UserController::class, 'change_foto']);

    });

    Route::prefix('product')->group(function(){
        Route::get('/', [ProductController::class, 'show']);
        Route::post('/', [ProductController::class, 'create']);
        Route::get('/{id}', [ProductController::class, 'read']);
        Route::post('/update/{id}', [ProductController::class, 'update']);
        Route::delete('/{id}', [ProductController::class, 'delete']);
        Route::post('/change-foto/{id}', [ProductController::class, 'change_foto']);
    });

    Route::prefix('transaction')->group(function(){
        Route::get('/', [TransactionController::class, 'show']);
        Route::get('/by_user/{id}', [TransactionController::class, 'show_by_user']);
        Route::post('/', [TransactionController::class, 'create']);
        Route::delete('/{id}', [TransactionController::class, 'delete']);
    });
});
