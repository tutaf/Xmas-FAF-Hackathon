<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\AuthController;

Route::get('/test', function () {
    return 'DFdfdf';
});

Route::controller(AuthController::class)->group(function () {
    Route::post('login', 'login');
    Route::post('register', 'register');
    Route::post('logout', 'logout');
    Route::post('get-user', 'user');
});


Route::middleware([\App\Http\Middleware\API::class])->group(function () {
    Route::controller(\App\Http\Controllers\OrphanController::class)->group(function () {
        Route::post('get-all-orphans/{id}', 'getAll');
        Route::post('get-orphan/{id}', 'getOrphanById');
        Route::post('create-orphan', 'createOrphan');
    });
    Route::controller(\App\Http\Controllers\OrphanBuildingController::class)->group(function () {
        Route::post('get-orphan-building', 'getByLocation');
        Route::post('get-orphan-building-by-id/{id}', 'getOrphanById');
        Route::post('get-all-orphan-buildings', 'getAll');
        Route::post('create-orphan-building', 'createOrphanBuilding');
    });
});
