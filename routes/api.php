<?php

use App\Http\Controllers\TagsController;
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

Route::group(['prefix' => 'tags'], function() {
    Route::get('/', [TagsController::class, 'all']);
    Route::post('/', [TagsController::class, 'create']);
    Route::put('/{id}', [TagsController::class, 'update']);
    Route::delete('/{id}', [TagsController::class, 'delete']);
    Route::get('/{id}', [TagsController::class, 'show']);
});
