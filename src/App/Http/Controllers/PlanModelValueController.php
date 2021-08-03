<?php

namespace Asseco\PlanRouter\App\Http\Controllers;

use Asseco\PlanRouter\App\Http\Requests\PlanModelValueRequest;
use Asseco\PlanRouter\App\Models\PlanModelValue;
use Exception;
use Illuminate\Http\JsonResponse;

class PlanModelValueController extends Controller
{
    public PlanModelValue $planModelValue;

    public function __construct()
    {
        $model = config('asseco-plan-router.plan_model_value_model');

        $this->planModelValue = new $model;
    }

    /**
     * Display a listing of the resource.
     *
     * @return JsonResponse
     */
    public function index(): JsonResponse
    {
        return response()->json($this->planModelValue::all());
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param PlanModelValueRequest $request
     * @return JsonResponse
     */
    public function store(PlanModelValueRequest $request): JsonResponse
    {
        $planModelValue = $this->planModelValue::query()->create($request->validated());

        return response()->json($planModelValue->refresh());
    }

    /**
     * Display the specified resource.
     *
     * @param PlanModelValue $planModelValue
     * @return JsonResponse
     */
    public function show(PlanModelValue $planModelValue): JsonResponse
    {
        return response()->json($planModelValue);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param PlanModelValueRequest $request
     * @param PlanModelValue $planModelValue
     * @return JsonResponse
     */
    public function update(PlanModelValueRequest $request, PlanModelValue $planModelValue): JsonResponse
    {
        $planModelValue->update($request->validated());

        return response()->json($planModelValue->refresh());
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param PlanModelValue $planModelValue
     * @return JsonResponse
     * @throws Exception
     */
    public function destroy(PlanModelValue $planModelValue): JsonResponse
    {
        $isDeleted = $planModelValue->delete();

        return response()->json($isDeleted ? 'true' : 'false');
    }
}
