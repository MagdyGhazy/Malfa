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


/** ===========| Address |============================| 2025-05-03 |================= **/
Route::group(['prefix' => 'address', 'middleware' => 'auth:sanctum'], function () {
    Route::controller(\App\Http\Controllers\Api\Address\AddressController::class)->group(function () {
        Route::get('/', 'index')->middleware('permission:list addresses');
        Route::get('/{id}', 'show')->middleware('permission:show addresses');
        Route::post('/', 'store')->middleware('permission:create addresses');
        Route::put('/{id}', 'update')->middleware('permission:edit addresses');
        Route::delete('/{id}', 'destroy')->middleware('permission:delete addresses');
    });
});


/** ===========| Country |============================| 2025-05-03 |================= **/
Route::group(['prefix' => 'country', 'middleware' => 'auth:sanctum'], function () {
    Route::controller(\App\Http\Controllers\Api\Country\CountryController::class)->group(function () {
        Route::get('/', 'index')->middleware('permission:list countries');
        Route::get('/{id}', 'show')->middleware('permission:show countries');
        Route::get('/state/{id}', 'getCities')->middleware('permission:show countries');
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


/** ===========| Landing |============================| 2025-05-03 |================= **/
Route::group(['prefix' => 'user_landing'], function () {
    Route::controller(\App\Http\Controllers\Api\Landing\LandingController::class)->group(function () {
        Route::get('/', 'index');
        Route::get('/{id}', 'show');
    });
});

Route::group(['prefix' => 'landing', 'middleware' => 'auth:sanctum'], function () {
    Route::controller(\App\Http\Controllers\Api\Landing\LandingController::class)->group(function () {
        Route::post('/', 'store')->middleware('permission:create landings');
        Route::put('/{id}', 'update')->middleware('permission:edit landings');
        Route::delete('/{id}', 'destroy')->middleware('permission:delete landings');
    });
});

/** ===========| Unit |============================| 2025-05-04 |================= **/
Route::group(['prefix' => 'unit', 'middleware' => 'auth:sanctum'], function () {
    Route::controller(\App\Http\Controllers\Api\Unit\UnitController::class)->group(function () {
        Route::get('/', 'index')->middleware('permission:list units');
        Route::get('/{id}', 'show')->middleware('permission:show units');
        Route::post('/', 'store')->middleware('permission:create units');
        Route::put('/{id}', 'update')->middleware('permission:edit units');
        Route::delete('/{id}', 'destroy')->middleware('permission:delete units');
    });
});


/** ===========| Activity |============================| 2025-05-06 |================= **/
Route::group(['prefix' => 'activity', 'middleware' => 'auth:sanctum'], function () {
    Route::controller(\App\Http\Controllers\Api\Activity\ActivityController::class)->group(function () {
        Route::get('/', 'index')->middleware('permission:list activitys');
        Route::get('/{id}', 'show')->middleware('permission:show activitys');
        Route::post('/', 'store')->middleware('permission:create activitys');
        Route::put('/{id}', 'update')->middleware('permission:edit activitys');
        Route::delete('/{id}', 'destroy')->middleware('permission:delete activitys');
    });
});


/** ===========| Room |============================| 2025-05-06 |================= **/
Route::group(['prefix' => 'room', 'middleware' => 'auth:sanctum'], function () {
    Route::controller(\App\Http\Controllers\Api\Room\RoomController::class)->group(function () {
        Route::get('/', 'index')->middleware('permission:list rooms');
        Route::get('/{id}', 'show')->middleware('permission:show rooms');
        Route::post('/', 'store')->middleware('permission:create rooms');
        Route::put('/{id}', 'update')->middleware('permission:edit rooms');
        Route::delete('/{id}', 'destroy')->middleware('permission:delete rooms');
        Route::post('/is_available/{id}','toggleStatus')->middleware('permission:edit rooms');
    });
});
