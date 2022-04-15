<?php

namespace Asseco\PlanRouter\App\Events;

use Asseco\PlanRouter\App\Contracts\Plan;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class PlanUpdated implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    protected Plan $plan;

    /**
     * Create a new event instance.
     *
     * @param Plan $plan
     */
    public function __construct(Plan $plan)
    {
        $this->plan = $plan->load(['rules', 'values']);
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