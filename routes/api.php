<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\MenuController;

Route::controller(AuthController::class)->group(function () {
    Route::post("/auth", "create");
});

Route::post("/user", [UserController::class, "create"]);

Route::middleware("auth:sanctum")->controller(UserController::class)->prefix("user")->group(function () {
    Route::put("", "edit");
    Route::delete("", "destroy");
});

Route::middleware("auth:sanctum")->controller(MenuController::class)->prefix("menu")->group(function () {
    Route::get("", "index");
    Route::post("", "create");
    Route::put("/{permalink}", "edit");
    Route::delete("/{permalink}", "destroy");
});
