<?php

namespace Asseco\PlanRouter\App\Http\Controllers;

use Asseco\PlanRouter\App\Contracts\Match as MatchContract;
use Illuminate\Http\JsonResponse;

class MatchController extends Controller
{
    public MatchContract $match;

    public function __construct(MatchContract $match)
    {
        $this->match = $match;
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
