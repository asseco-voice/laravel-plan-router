<?php

namespace Asseco\PlanRouter\App\Services;

use Asseco\Inbox\Contracts\Message;
use Asseco\Inbox\Facades\InboxGroup;
use Asseco\Inbox\Inbox;
use Asseco\PlanRouter\App\Contracts\CanPlan;
use Asseco\PlanRouter\App\Models\Plan;
use Illuminate\Support\Collection;

class InboxService
{
    protected CanPlan $canPlan;
    protected Message $message;

    public function __construct(CanPlan $canPlan)
    {
        $this->canPlan = $canPlan;
    }

    public function receive(Message $message): void
    {
        $this->message = $message;

        $this->registerInboxes();

        $this->registerFallback();

        InboxGroup::run($message);
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
            ->action(fn () => $this->canPlan->callback($this->message, $plan->skillGroup->id))
            ->matchEither($plan->match_either)
            ->priority($plan->priority);

        return $inbox;
    }

    protected function registerInboxPatterns(Collection $matches, Inbox $inbox): void
    {
        // Adding timestamp because no 2 same pattern
        // names can be registered for a single mailbox
        $timestamp = now()->timestamp;

        foreach ($matches as $matchBy) {
            $method = $matchBy->name;
            $pattern = $matchBy->pivot->regex;

            // Method is one of [from, to, cc, bcc, subject] in a default configuration
            $inbox->{$method}("{pattern_$timestamp}");
            $inbox->where("pattern_$timestamp", trim($pattern, '/'));
            $timestamp++;
        }
    }

    protected function registerFallback(): void
    {
        InboxGroup::fallback(fn () => $this->canPlan->fallback($this->message));
    }
}
