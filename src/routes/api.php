<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Enums\TokenAbility;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\ReminderController;

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

Route::post('register', [AuthController::class, 'register']);
Route::post('login', [AuthController::class, 'login']);

Route::group(['middleware' => ['auth:sanctum','ability:'.TokenAbility::ISSUE_ACCESS_TOKEN->value]], function() {
    Route::post('refresh-token', [AuthController::class, 'refreshToken']);
});

Route::group(['middleware' => ['auth:sanctum','ability:'.TokenAbility::ACCESS_API->value]], function() {
    Route::get('/user', function (Request $request) {
        return $request->user();
    });
    Route::post('reminders', [ReminderController::class, 'create']);
    Route::get('reminders', [ReminderController::class, 'getLists']);
    Route::get('reminders/{id}', [ReminderController::class, 'getDetail']);
});


