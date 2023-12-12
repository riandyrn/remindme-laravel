<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::group(['prefix' => 'v1'], function () {
    Route::get('/', function () {
        return response()->json([
            'status' => true,
            'message' => 'Selamat Datang'
        ]);
    });
});
