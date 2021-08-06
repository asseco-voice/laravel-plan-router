<?php

namespace Asseco\PlanRouter\App\Models\Decorators;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Traits\ForwardsCalls;

class SoftDelete
{
    use ForwardsCalls, SoftDeletes;

    protected Model $model;

    public function __construct(Model $model)
    {
        $this->model = $model;
    }

    public function __call($method, $parameters)
    {
        return $this->forwardCallTo($this->model, $method, $parameters);
    }
}
