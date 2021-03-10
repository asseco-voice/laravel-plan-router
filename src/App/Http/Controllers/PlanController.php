<?php

namespace Asseco\PlanRouter\App\Http\Controllers;

use Asseco\PlanRouter\App\Models\Plan;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class PlanController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return JsonResponse
     */
    public function index(): JsonResponse
    {
        return response()->json(Plan::all());
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function store(Request $request): JsonResponse
    {
        $plan = Plan::query()->create($request->all());

        return response()->json($plan->refresh());
    }

    /**
     * Display the specified resource.
     *
     * @param Plan $plan
     * @return JsonResponse
     */
    public function show(Plan $plan): JsonResponse
    {
        return response()->json($plan);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param Plan $plan
     * @return JsonResponse
     */
    public function update(Request $request, Plan $plan): JsonResponse
    {
        $plan->update($request->all());

        return response()->json($plan->refresh());
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Plan $plan
     * @return JsonResponse
     * @throws Exception
     */
    public function destroy(Plan $plan): JsonResponse
    {
        $isDeleted = $plan->delete();

        return response()->json($isDeleted ? 'true' : 'false');
    }
}
