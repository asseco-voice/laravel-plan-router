<?php

namespace Asseco\PlanRouter\App\Contracts;

use Asseco\Inbox\Contracts\CanMatch;

interface CanPlan extends CanMatch
{
    /**
     * Callback to be executed when plan is matched.
     *
     * @param CanMatch $message
     * @param int $skillGroupId
     */
    public static function planCallback(CanMatch $message, int $skillGroupId): void;

    /**
     * Callback to be executed when no plan matched.
     *
     * @param CanMatch $message
     */
    public static function planFallback(CanMatch $message): void;
}
