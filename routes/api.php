<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Api\EGroupController;
use App\Http\Controllers\Api\Auth\AuthController;
use App\Http\Controllers\Api\Auth\RegisterController;
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

Route::post('/login', [AuthController::class, 'login']);
Route::post('/register', RegisterController::class);
Route::get('/egroups', [EGroupController::class, 'index']);
Route::get('/ministries', [App\Http\Controllers\Api\MinistryController::class, 'index']);
Route::get('/ministries/{ministry}', [App\Http\Controllers\Api\MinistryController::class, 'show']);

Route::middleware('auth:sanctum')->group(function () {
    Route::get('/user', function (Request $request) {
        return $request->user();
    });
    Route::post('/ministries/{ministry}/join-requests', [App\Http\Controllers\Api\MinistryJoinRequestController::class, 'store']);
    Route::post('/egroups/{egroup}/join-requests', [EGroupController::class, 'joinRequest']);
});