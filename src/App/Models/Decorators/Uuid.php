<?php

namespace Asseco\PlanRouter\App\Models;

use Asseco\PlanRouter\App\Traits\Uuids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Traits\ForwardsCalls;

class Uuid
{
    use ForwardsCalls, Uuids;

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
