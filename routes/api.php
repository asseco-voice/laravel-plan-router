<?php

use Asseco\PlanRouter\App\Http\Controllers\PlanController;
use Asseco\PlanRouter\App\Http\Controllers\PlanModelValueController;
use Asseco\PlanRouter\App\Http\Controllers\PlanRuleController;
use Asseco\PlanRouter\App\Http\Controllers\RuleController;
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

Route::prefix(config('asseco-plan-router.routes.prefix'))
    ->middleware(config('asseco-plan-router.routes.middleware'))
    ->group(function () {
        Route::apiResource('rules', RuleController::class)->only('index');
        Route::apiResource('plans', PlanController::class);
        Route::apiResource('plan-model-values', PlanModelValueController::class);

        Route::prefix('plans/{plan}')->name('plans.')->group(function () {
            Route::get('rules', [PlanRuleController::class, 'index'])->name('rules.index');
            Route::post('rules', [PlanRuleController::class, 'store'])->name('rules.store');
            Route::match(['put', 'patch'], 'rules', [PlanRuleController::class, 'update'])->name('rules.update');
            Route::delete('rules', [PlanRuleController::class, 'destroy'])->name('rules.destroy');
        });
    });
