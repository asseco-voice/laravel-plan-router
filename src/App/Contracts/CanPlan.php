<?php

namespace Asseco\PlanRouter\App\Contracts;

use Asseco\Inbox\Contracts\CanMatch;

interface CanPlan extends CanMatch
{
    /**
     * Callback to be executed when plan is matched.
     *
     * @param CanPlan $message
     * @param int $skillGroupId
     */
    public static function planCallback(CanPlan $message, int $skillGroupId): void;

    /**
     * Callback to be executed when no plan matched.
     *
     * @param CanPlan $message
     */
    public static function planFallback(CanPlan $message): void;
}
