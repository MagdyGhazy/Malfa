<?php

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


    /** =================| Auth |====================| 2025-04-25 |================= **/
    Route::post('/register', [\App\Http\Controllers\Api\Auth\AuthController::class, 'register']);
    Route::post('/login', [\App\Http\Controllers\Api\Auth\AuthController::class, 'login']);
    Route::get('/logout', [\App\Http\Controllers\Api\Auth\AuthController::class, 'logout'])->middleware('auth:sanctum');



    /** ===========| Role |============================| 2025-04-25 |================= **/
    Route::group(['prefix' => 'role', 'middleware' => 'auth:sanctum'], function () {
        Route::controller(\App\Http\Controllers\Api\Role\RoleController::class)->group(function () {
            Route::get('/', 'index')->middleware('permission:list roles');
            Route::get('/{id}', 'show')->middleware('permission:show roles');
            Route::post('/', 'store')->middleware('permission:create roles');
            Route::put('/{id}', 'update')->middleware('permission:edit roles');
            Route::delete('/{id}', 'destroy')->middleware('permission:delete roles');
            Route::get('get/permissions', 'allPermissions')->middleware('permission:list permissions');
            Route::put('permission/{id}', 'updatePermission')->middleware('permission:edit permissions');
        });
    });



     /** ===========| User |============================| 2025-04-25 |================= **/
     Route::group(['prefix' => 'user', 'middleware' => 'auth:sanctum'], function () {
         Route::controller(\App\Http\Controllers\Api\User\UserController::class)->group(function () {
             Route::get('/', 'index')->middleware('permission:list users');
             Route::get('/{id}', 'show')->middleware('permission:show users');
             Route::post('/', 'store')->middleware('permission:create users');
             Route::put('/{id}', 'update')->middleware('permission:edit users');
             Route::delete('/{id}', 'destroy')->middleware('permission:delete users');
         });
     });



     /** ===========| Feature |============================| 2025-05-03 |================= **/
     Route::group(['prefix' => 'feature', 'middleware' => 'auth:sanctum'], function () {
         Route::controller(\App\Http\Controllers\Api\Feature\FeatureController::class)->group(function () {
             Route::get('/', 'index')->middleware('permission:list features');
             Route::get('/{id}', 'show')->middleware('permission:show features');
             Route::post('/', 'store')->middleware('permission:create features');
             Route::put('/{id}', 'update')->middleware('permission:edit features');
             Route::delete('/{id}', 'destroy')->middleware('permission:delete features');
         });
     });
