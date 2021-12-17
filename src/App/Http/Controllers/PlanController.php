<?php

namespace Asseco\PlanRouter\App\Http\Controllers;

use Asseco\PlanRouter\App\Contracts\Plan as PlanContract;
use Asseco\PlanRouter\App\Http\Requests\PlanRequest;
use Asseco\PlanRouter\App\Models\Plan;
use Illuminate\Http\JsonResponse;

class PlanController extends Controller
{
    public PlanContract $plan;

    public function __construct(PlanContract $plan)
    {
        $this->plan = $plan;
    }

    /**
     * Display a listing of the resource.
     *
     * @return JsonResponse
     */
    public function index(): JsonResponse
    {
        return response()->json($this->plan::all());
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  PlanRequest  $request
     * @return JsonResponse
     */
    public function store(PlanRequest $request): JsonResponse
    {
        $plan = $this->plan::query()->create($request->validated());

        return response()->json($plan->refresh());
    }

    /**
     * Display the specified resource.
     *
     * @param  Plan  $plan
     * @return JsonResponse
     */
    public function show(Plan $plan): JsonResponse
    {
        return response()->json($plan);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  PlanRequest  $request
     * @param  Plan  $plan
     * @return JsonResponse
     */
    public function update(PlanRequest $request, Plan $plan): JsonResponse
    {
        $plan->update($request->validated());

        return response()->json($plan->refresh());
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  Plan  $plan
     * @return JsonResponse
     */
    public function destroy(Plan $plan): JsonResponse
    {
        $isDeleted = $plan->delete();

        return response()->json($isDeleted ? 'true' : 'false');
    }
}
