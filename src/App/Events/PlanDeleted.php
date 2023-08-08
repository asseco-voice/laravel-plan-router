<?php

namespace Asseco\PlanRouter\App\Events;

use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;

class PlanDeleted implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets;

    protected $planId;

    /**
     * Create a new event instance.
     *
     * @param  $planId
     */
    public function __construct($planId)
    {
        $this->planId = $planId;
    }

    public function broadcastQueue()
    {
        return config('asseco-plan-router.plan_event_topic');
    }

    public function broadcastOn()
    {
        return [];
    }
}
