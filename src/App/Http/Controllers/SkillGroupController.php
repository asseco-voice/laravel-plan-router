<?php

namespace Asseco\PlanRouter\App\Http\Controllers;

use Asseco\PlanRouter\App\Models\SkillGroup;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class SkillGroupController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return JsonResponse
     */
    public function index(): JsonResponse
    {
        return response()->json(SkillGroup::all());
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function store(Request $request): JsonResponse
    {
        $skillGroup = SkillGroup::query()->create($request->all());

        return response()->json($skillGroup->refresh());
    }

    /**
     * Display the specified resource.
     *
     * @param SkillGroup $skillGroup
     * @return JsonResponse
     */
    public function show(SkillGroup $skillGroup): JsonResponse
    {
        return response()->json($skillGroup);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param SkillGroup $skillGroup
     * @return JsonResponse
     */
    public function update(Request $request, SkillGroup $skillGroup): JsonResponse
    {
        $skillGroup->update($request->all());

        return response()->json($skillGroup->refresh());
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param SkillGroup $skillGroup
     * @return JsonResponse
     * @throws Exception
     */
    public function destroy(SkillGroup $skillGroup): JsonResponse
    {
        $isDeleted = $skillGroup->delete();

        return response()->json($isDeleted ? 'true' : 'false');
    }
}
