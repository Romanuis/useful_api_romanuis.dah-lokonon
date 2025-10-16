<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ShortLinkController;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');



// Redirection publique
Route::get('/s/{code}', [ShortLinkController::class, 'redirect']);

// Routes protégées
Route::middleware(['auth:api', 'module.active:1'])->group(function () {
    Route::post('/shorten', [ShortLinkController::class, 'shorten']);
    Route::get('/links', [ShortLinkController::class, 'index']);
    Route::delete('/links/{id}', [ShortLinkController::class, 'destroy']);
});