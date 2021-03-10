<?php

namespace Asseco\PlanRouter\App\Http\Controllers;

use Asseco\PlanRouter\App\Models\PlanTemplate;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class PlanTemplateController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return JsonResponse
     */
    public function index(): JsonResponse
    {
        return response()->json(PlanTemplate::all());
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function store(Request $request): JsonResponse
    {
        $planTemplate = PlanTemplate::query()->create($request->all());

        return response()->json($planTemplate->refresh());
    }

    /**
     * Display the specified resource.
     *
     * @param PlanTemplate $planTemplate
     * @return JsonResponse
     */
    public function show(PlanTemplate $planTemplate): JsonResponse
    {
        return response()->json($planTemplate);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param PlanTemplate $planTemplate
     * @return JsonResponse
     */
    public function update(Request $request, PlanTemplate $planTemplate): JsonResponse
    {
        $planTemplate->update($request->all());

        return response()->json($planTemplate->refresh());
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param PlanTemplate $planTemplate
     * @return JsonResponse
     * @throws Exception
     */
    public function destroy(PlanTemplate $planTemplate): JsonResponse
    {
        $isDeleted = $planTemplate->delete();

        return response()->json($isDeleted ? 'true' : 'false');
    }
}
