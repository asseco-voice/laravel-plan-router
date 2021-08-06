<?php

namespace Asseco\PlanRouter\App\Models\Decorators;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Traits\ForwardsCalls;

class Audit
{
    use ForwardsCalls, \Asseco\BlueprintAudit\App\Traits\Audit;

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
