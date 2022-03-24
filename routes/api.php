<?php

use App\Http\Controllers\AuthApiController;
use App\Http\Controllers\DeputadoEstadualApiController;
use App\Http\Controllers\DeputadoFederalApiController;
use App\Http\Controllers\GovernadorApiController;
use App\Http\Controllers\PresidenteApiController;
use App\Http\Controllers\SenadorApiController;
use Illuminate\Support\Facades\Route;


Route::post('cadastro', [AuthApiController::class, "register"]); //ok

Route::delete('cadastro/{id}',[AuthApiController::class,"destroy"]);//ok

Route::post('login', [AuthApiController::class, "login"]); //ok

Route::post('logout', [AuthApiController::class, "logout"]);//ok

Route::post('login-refresh', [AuthApiController::class, "refreshToken"]); //need token

Route::get('votação', [AuthApiController::class, "votation"]); //need token


Route::group(['middleware'=>'auth:api'],function () { //ok
Route::apiResource('presidente', PresidenteApiController::class);

Route::apiResource('senador', SenadorApiController::class);

Route::apiResource('governador', GovernadorApiController::class);

Route::apiResource('deputado-federal', DeputadoFederalApiController::class);

Route::apiResource('deputado-estadual', DeputadoEstadualApiController::class);

});
