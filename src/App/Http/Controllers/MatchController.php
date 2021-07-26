<?php

namespace Asseco\PlanRouter\App\Http\Controllers;

use Asseco\PlanRouter\App\Models\Match;
use Illuminate\Http\JsonResponse;

class MatchController extends Controller
{
    public Match $match;

    public function __construct()
    {
        $model = config('asseco-plan-router.match_model');

        $this->match = new $model;
    }

    /**
     * Display a listing of the resource.
     *
     * @return JsonResponse
     */
    public function index(): JsonResponse
    {
        return response()->json($this->match::all());
    }
}
