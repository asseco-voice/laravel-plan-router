<?php

namespace Asseco\PlanRouter\App\Http\Controllers;

use Asseco\PlanRouter\App\Http\Requests\PlanRuleDeleteRequest;
use Asseco\PlanRouter\App\Http\Requests\PlanRuleRequest;
use Asseco\PlanRouter\App\Models\Plan;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Arr;

class PlanRuleController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param  Plan  $plan
     * @return JsonResponse
     */
    public function index(Plan $plan): JsonResponse
    {
        return response()->json($plan->rules);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  Plan  $plan
     * @param  PlanRuleRequest  $request
     * @return JsonResponse
     */
    public function store(Plan $plan, PlanRuleRequest $request): JsonResponse
    {
        $planRules = Arr::get($request->validated(), 'rules');

        foreach ($planRules as $rule) {
            $plan->rules()->attach(Arr::get($rule, 'rule_id'), Arr::except($rule, 'rule_id'));
        }

        return response()->json($plan->refresh()->load('rules'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  Plan  $plan
     * @param  PlanRuleRequest  $request
     * @return JsonResponse
     */
    public function update(Plan $plan, PlanRuleRequest $request): JsonResponse
    {
        $validated = $request->validated();

        $planRules = Arr::get($validated, 'rules');

        foreach ($planRules as $rule) {
            $plan->rules()->updateExistingPivot(Arr::get($rule, 'rule_id'), Arr::except($rule, 'rule_id'));
        }

        return response()->json($plan->refresh()->load('rules'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  Plan  $plan
     * @param  PlanRuleDeleteRequest  $request
     * @return JsonResponse
     */
    public function destroy(Plan $plan, PlanRuleDeleteRequest $request): JsonResponse
    {
        $ids = Arr::get($request->validated(), 'rule_ids', []);

        $plan->rules()->detach($ids);

        return response()->json('success');
    }
}
