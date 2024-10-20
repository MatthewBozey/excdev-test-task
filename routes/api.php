<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::post('/login', [\App\Http\Controllers\LoginController::class, 'authenticate']);

Route::middleware('auth:sanctum')
    ->get('/users/balance', [\App\Http\Controllers\UserController::class, 'getBalance']);

Route::middleware('auth:sanctum')
    ->apiResource('/users', 'App\Http\Controllers\UserController')
    ->parameters(['users' => 'id']);

Route::middleware('auth:sanctum')
    ->apiResource('/balance-operation', \App\Http\Controllers\BalanceOperationController::class)
    ->only(['index'])
    ->parameters(['balance-operation' => 'id']);

Route::middleware(['auth:sanctum', 'check-user-balance'])
    ->post('/balance-operation', [\App\Http\Controllers\BalanceOperationController::class, 'execOperation']);

Route::middleware('auth:sanctum')
    ->apiResource('/operation-type', \App\Http\Controllers\OperationTypeController::class)
    ->parameters(['operation-type' => 'id']);
