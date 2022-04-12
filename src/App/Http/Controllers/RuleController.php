<?php

namespace Asseco\PlanRouter\App\Http\Controllers;

use Asseco\PlanRouter\App\Contracts\Rule as RuleContract;
use Illuminate\Http\JsonResponse;

class RuleController extends Controller
{
    public RuleContract $rule;

    public function __construct(RuleContract $rule)
    {
        $this->rule = $rule;
    }

    /**
     * Display a listing of the resource.
     *
     * @return JsonResponse
     */
    public function index(): JsonResponse
    {
        return response()->json($this->rule::all());
    }
}
