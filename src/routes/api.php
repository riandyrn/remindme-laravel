<?php

use App\Enums\TokenAbility;
use App\Http\Controllers\AuthController;
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

Route::post('/session', [AuthController::class, 'login']);

Route::middleware([
    'auth:sanctum',
    'ability:' . TokenAbility::ISSUE_ACCESS_TOKEN->value,
])->put('/session', [AuthController::class, 'refresh']);

Route::middleware(
    'auth:sanctum',
    'ability:' . TokenAbility::ACCESS_API->value
)->group(function () {
    //
});
