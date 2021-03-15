<?php

namespace Asseco\PlanRouter\App\Services;

use Asseco\Inbox\Contracts\Message as MessageContract;
use Asseco\Inbox\Facades\InboxGroup;
use Asseco\Inbox\Inbox;
use Asseco\PlanRouter\App\Models\Plan;
use Illuminate\Support\Collection;

class InboxService
{
    public function receiveEmail(MessageContract $message): void
    {
        $this->registerInboxes();

        $this->inboxFallback();

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

        $callback = config('asseco-plan-router.inbox_callback');

        $inbox
            ->action($callback($plan->skillGroup->id))
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

            // Method is one of: [from, to, cc, bcc, subject]
            $inbox->{$method}("{pattern_$timestamp}");
            $inbox->where("pattern_$timestamp", trim($pattern, '/'));
            $timestamp++;
        }
    }

    protected function inboxFallback(): void
    {
        $callback = config('asseco-plan-router.inbox_fallback');

        InboxGroup::fallback($callback());
    }
}
