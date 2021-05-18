<?php

namespace Asseco\PlanRouter\App\Facades;

use Asseco\Inbox\Contracts\CanMatch;
use Asseco\PlanRouter\App\Models\Plan;
use Illuminate\Support\Facades\Facade;

/**
 * @method static Plan|null match(CanMatch $canMatch)
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
