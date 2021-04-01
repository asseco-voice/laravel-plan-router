<?php

namespace Asseco\PlanRouter\App\Services;

use Asseco\Inbox\Facades\InboxGroup;
use Asseco\Inbox\Inbox;
use Asseco\PlanRouter\App\Contracts\CanPlan;
use Asseco\PlanRouter\App\Models\Plan;
use Illuminate\Support\Collection;

class InboxService
{
    protected CanPlan $canPlan;

    public function receive(CanPlan $canPlan): void
    {
        $this->canPlan = $canPlan;

        $this->registerInboxes();

        $this->registerFallback();

        InboxGroup::run($canPlan);
    }

    protected function registerInboxes(): void
    {
        $plans = Plan::getWithRelations();

        foreach ($plans as $plan) {
            $inbox = $this->createInbox($plan);
            InboxGroup::add($inbox);
        }
    }

    protected function createInbox(Plan $plan): Inbox
    {
        $inbox = new Inbox();

        $this->registerInboxPatterns($plan->matches, $inbox);

        $inbox
            ->action(fn () => $this->canPlan->planCallback($this->canPlan, $plan->skillGroup->id))
            ->matchEither($plan->match_either)
            ->priority($plan->priority);

        return $inbox;
    }

    /**
     * @param Collection $matches
     * @param Inbox $inbox
     * @throws \Exception
     */
    protected function registerInboxPatterns(Collection $matches, Inbox $inbox): void
    {
        // Adding timestamp because no 2 same pattern
        // names can be registered for a single mailbox
        $timestamp = now()->timestamp;

        foreach ($matches as $matchBy) {
            $attribute = $matchBy->name;
            $pattern = $matchBy->pivot->regex;

            $inbox->setPattern($attribute, "{pattern_$timestamp}");
            $inbox->where("pattern_$timestamp", trim($pattern, '/'));

            $timestamp++;
        }
    }

    protected function registerFallback(): void
    {
        InboxGroup::fallback(fn () => $this->canPlan->planFallback($this->canPlan));
    }
}
