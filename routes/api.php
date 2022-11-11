<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\UserController;

Route::controller(AuthController::class)->group(function () {
    Route::post("/auth", "create");
    Route::delete("/auth", "destroy");
});

Route::middleware("auth:sanctum")->controller(UserController::class)->prefix("user")->group(function () {
    Route::post("","create");
});
