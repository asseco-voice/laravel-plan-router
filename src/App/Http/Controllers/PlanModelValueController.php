<?php

namespace Asseco\PlanRouter\App\Http\Controllers;

use Asseco\PlanRouter\App\Models\PlanModelValue;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class PlanModelValueController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return JsonResponse
     */
    public function index(): JsonResponse
    {
        return response()->json(PlanModelValue::all());
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function store(Request $request): JsonResponse
    {
        $planModelValue = PlanModelValue::query()->create($request->all());

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
     * @param Request $request
     * @param PlanModelValue $planModelValue
     * @return JsonResponse
     */
    public function update(Request $request, PlanModelValue $planModelValue): JsonResponse
    {
        $planModelValue->update($request->all());

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
