<?php

use App\Enums\TokenAbility;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\RemindersController;

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

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });

Route::post('/session', [AuthController::class, 'login']);
Route::put('/session', [AuthController::class, 'refreshAccessToken'])->middleware([
    'auth.rt:sanctum',
    'ability:'. TokenAbility::ISSUE_ACCESS_TOKEN->value
]);

Route::prefix('reminders')->group(function() {
    Route::post('/', [RemindersController::class, 'create']);
})->middleware('auth:sanctum', 'ability:'. TokenAbility::ACCESS_API->value);