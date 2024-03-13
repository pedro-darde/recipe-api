<?php

use App\Http\Controllers\RecipeController;
use App\Http\Controllers\TagsController;
use App\Http\Middleware\Can;
use App\Http\Middleware\TrustProxies;
use Fruitcake\Cors\CorsService;
use Illuminate\Http\Middleware\HandleCors;
use Illuminate\Http\Request;
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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});


Route::middleware([\App\Http\Middleware\Authenticate::class])->group(function () {
    Route::group(['tags'], function () {
        Route::get('/tags', [TagsController::class, 'all']);
        Route::post('/tags', [TagsController::class, 'create']);
        Route::put('/tags/{id}', [TagsController::class, 'update']);
        Route::delete('/tags/{id}', [TagsController::class, 'delete']);
        Route::get('/tags/{id}', [TagsController::class, 'show']);
    });

    Route::group(["recipes"], function () {
        Route::get('/recipes', [RecipeController::class, 'all']);
        Route::post('/recipes', [RecipeController::class, 'create']);
        Route::put('/recipes/{id}', [RecipeController::class, 'update']);
        Route::delete('/recipes/{id}', [RecipeController::class, 'delete']);
        Route::get('/recipes/{id}', [RecipeController::class, 'show']);
    });

    Route::prefix('json')->group(function() {
        Route::get("/tags", [\App\Http\Controllers\JsonController::class, 'getTags']);
    });
});

