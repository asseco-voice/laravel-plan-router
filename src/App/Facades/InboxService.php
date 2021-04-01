<?php

namespace Asseco\PlanRouter\App\Facades;

use Asseco\PlanRouter\App\Contracts\CanPlan;
use Illuminate\Support\Facades\Facade;

/**
 * @method static void receive(CanPlan $canPlan)
 *
 * @see \Asseco\PlanRouter\App\Services\InboxService
 */
class InboxService extends Facade
{
    protected static function getFacadeAccessor()
    {
        return 'inbox-service';
    }
}
