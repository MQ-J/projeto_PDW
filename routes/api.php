<?php

/**
 * IMPORT CONTROLLERS
 */
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PessoasController;
use App\Http\Controllers\SllurpController;
use App\Http\Controllers\ReactMobileController;
use App\Http\Controllers\ProjetoSPAController;

/**
 * PESSOAS ROUTE'S
 */
    Route::get(
        '/pessoas/index',
        [PessoasController::class, 'index']
    );

    Route::post(
        '/pessoas/create',
        [PessoasController::class, 'create']
    );

    Route::get(
        '/pessoas/show/{id}',
        [PessoasController::class, 'show']
    );

    Route::get(
        '/pessoas/shownome/{nome}',
        [PessoasController::class, 'showNome']
    );

    Route::post(
        '/pessoas/update/{id}',
        [PessoasController::class, 'update']
    );

    Route::delete(
        '/pessoas/destroy/{id}',
    [PessoasController::class, 'destroy']
    );

    Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
        return $request->user();
    });

/**
 * SLLURP ROUTE'S
 */
    Route::get(
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
    Route::get(
        '/ReactMobile/getUsers',
        [ReactMobileController::class, 'getUsers']
    );
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
