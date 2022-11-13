<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\MenuController;
use App\Http\Controllers\BlockController;

Route::post("/auth", [AuthController::class, "create"]);
Route::middleware("auth:sanctum")->delete("/auth", [AuthController::class, "destroy"]);

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

Route::middleware("auth:sanctum")->controller(BlockController::class)->prefix("menu")->group(function () {
    Route::post("/{permalink}/block", "create");
    Route::put("/{permalink}/block/{id}", "edit");
    Route::delete("/{permalink}/block/{id}", "destroy");
});
