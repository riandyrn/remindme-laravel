<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\ReminderController;
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

Route::post('session', [AuthController::class, 'login'])->name('login');

Route::group(['middleware' => ['auth:sanctum']], function () {
    Route::put('session', [AuthController::class, 'refreshToken'])->name('refreshToken');

    Route::get('reminders', [ReminderController::class, 'index'])->name('reminders.index');
    Route::post('reminders', [ReminderController::class, 'store'])->name('reminders.store');
    Route::get('reminders/{reminder}', [ReminderController::class, 'show'])->name('reminders.show');
    Route::put('reminders/{reminder}', [ReminderController::class, 'update'])->name('reminders.update');
    Route::delete('reminders/{reminder}', [ReminderController::class, 'destroy'])->name('reminders.destroy');
});
