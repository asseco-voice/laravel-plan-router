<?php

namespace Asseco\PlanRouter\App\Facades;

use Asseco\Inbox\Contracts\Message;
use Illuminate\Support\Facades\Facade;

/**
 * @method static void receiveEmail(Message $message)
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
