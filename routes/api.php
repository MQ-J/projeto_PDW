<?php

/**
 * IMPORT CONTROLLERS
 */
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\SllurpController;
use App\Http\Controllers\ReactMobileController;
use App\Http\Controllers\ProjetoSPAController;
use App\Http\Controllers\UsersController;

/**
 * USERS
 */
    Route::get(
        '/users',
        [UsersController::class, 'index']
    );
    Route::post(
        '/users/create',
        [UsersController::class, 'create']
    );

/**
 * SLLURP ROUTE'S
 */
    Route::POST(
        'sllurp/getconnection',
        [SllurpController::class, 'getconnection']
    );
    Route::post(
        'sllurp/gettags',
        [SllurpController::class, 'gettags']
    );

/**
 * REACTMOBILE ROUTE'S
 */
    Route::POST(
        '/ReactMobile/login',
        [ReactMobileController::class, 'login']
    );
    Route::POST(
        '/ReactMobile/newUser',
        [ReactMobileController::class, 'newUser']
    );
    Route::POST(
        '/ReactMobile/deleteUser',
        [ReactMobileController::class, 'deleteUser']
    );
    Route::POST(
        '/ReactMobile/getBlocos',
        [ReactMobileController::class, 'getBlocos']
    );
    Route::POST(
        '/ReactMobile/updateBlocos',
        [ReactMobileController::class, 'updateBlocos']
    );
    Route::POST(
        '/ReactMobile/deleteBloco',
        [ReactMobileController::class, 'deleteBloco']
    );
    Route::POST(
        '/ReactMobile/newMenu',
        [ReactMobileController::class, 'newMenu']
    );

/**
 * PROJETO-SPA
 */
    Route::POST(
        '/spa/sendFeedback',
        [ProjetoSPAController::class, 'sendFeedback']
    );
    Route::GET(
        '/spa/getFeedbacks',
        [ProjetoSPAController::class, 'getFeedbacks']
    );
