<?php

namespace Asseco\PlanRouter\App\Services;

use Asseco\PlanRouter\App\Models\Message;
use Asseco\PlanRouter\App\Models\Plan;
use Asseco\Inbox\Contracts\Message as MessageContract;
use Asseco\Inbox\Facades\InboxGroup;
use Asseco\Inbox\InboundEmail;
use Asseco\Inbox\Inbox;
use Closure;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Log;

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
        $plans = Plan::getCached()->load(['matches', 'skillGroup']);

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
            ->action($this->inboxCallback($plan->skillGroup->id))
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

    protected function inboxCallback(int $skillGroupId): Closure
    {
        return function (InboundEmail $email) use ($skillGroupId) {
            Log::info("Plan match found for skill group ID: $skillGroupId.");
            Message::fromInbound($email, [$skillGroupId]);
        };
    }

    protected function inboxFallback(): void
    {
        InboxGroup::fallback(function (InboundEmail $email) {
            Log::info("Plan match not found. Triggering fallback...");
            Message::fromInbound($email);
        });
    }
}
