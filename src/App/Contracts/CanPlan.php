<?php

namespace Asseco\PlanRouter\App\Contracts;

use Asseco\Inbox\Contracts\Message;

interface CanPlan
{
    /**
     * Callback to be executed when plan is matched.
     *
     * @param Message $message
     * @param int $skillGroupId
     */
    public static function planCallback(Message $message, int $skillGroupId): void;

    /**
     * Callback to be executed when no plan matched
     *
     * @param Message $message
     */
    public static function planFallback(Message $message): void;
}
