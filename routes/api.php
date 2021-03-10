<?php

use Asseco\PlanRouter\App\Http\Controllers\MatchController;
use Asseco\PlanRouter\App\Http\Controllers\PlanController;
use Asseco\PlanRouter\App\Http\Controllers\PlanModelValueController;
use Asseco\PlanRouter\App\Http\Controllers\PlanTemplateController;
use Asseco\PlanRouter\App\Http\Controllers\SkillGroupController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::prefix('api')
    ->middleware('api')
    ->group(function () {

        Route::apiResource('matches', MatchController::class)->only('index');
        Route::apiResource('plans', PlanController::class);
        Route::apiResource('plan-templates', PlanTemplateController::class);
        Route::apiResource('plan-model-values', PlanModelValueController::class);
        Route::apiResource('skill-groups', SkillGroupController::class);

    });
