<?php

use App\Http\Controllers\ImageController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::get('images/', [ImageController::class, 'index']);
Route::post('images', [ImageController::class, 'store']);
Route::delete('images/{id}', [ImageController::class, 'destroy']);
