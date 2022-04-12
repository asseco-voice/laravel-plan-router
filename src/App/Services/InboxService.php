<?php

namespace Asseco\PlanRouter\App\Services;

use Asseco\Inbox\Contracts\CanMatch;
use Asseco\Inbox\Facades\InboxGroup;
use Asseco\Inbox\Inbox;
use Asseco\PlanRouter\App\Models\Plan;
use Exception;
use Illuminate\Support\Arr;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Log;

class InboxService
{
    protected CanMatch $canMatch;

    public Plan $plan;

    public function __construct(Plan $plan)
    {
        $this->plan = new $plan;
    }

    /**
     * @param  CanMatch  $canMatch
     * @return Plan|null
     *
     * @throws Exception
     */
    public function match(CanMatch $canMatch): ?Plan
    {
        $this->canMatch = $canMatch;

        $this->registerInboxes();

        $this->registerFallback();

        /** @var Inbox $matchedInbox */
        // Interested in first match only as we're not utilizing
        // continuous matching from Inbox package.
        $matchedInbox = Arr::get(InboxGroup::run($canMatch), '0');

        $planId = Arr::get($matchedInbox->getMeta(), 'plan_id');

        /** @var Plan $plan */
        $plan = $this->plan::query()->find($planId);

        return $plan;
    }

    /**
     * @throws Exception
     */
    protected function registerInboxes(): void
    {
        $plans = $this->plan::getWithRelations();

        foreach ($plans as $plan) {
            $inbox = $this->createInbox($plan);
            InboxGroup::add($inbox);
        }
    }

    /**
     * @param  Plan  $plan
     * @return Inbox
     *
     * @throws Exception
     */
    protected function createInbox(Plan $plan): Inbox
    {
        $inbox = new Inbox();

        $this->registerInboxPatterns($plan->rules, $inbox);

        $inbox
            ->meta(['plan_id' => $plan->id])
            ->action(fn () => Log::info("Matched plan ID {$plan->id}."))
            ->matchEither($plan->match_either)
            ->priority($plan->priority);

        return $inbox;
    }

    /**
     * @param  Collection  $matches
     * @param  Inbox  $inbox
     *
     * @throws Exception
     */
    protected function registerInboxPatterns(Collection $matches, Inbox $inbox): void
    {
        foreach ($matches as $matchBy) {
            $attribute = $matchBy->name;
            $pattern = $matchBy->pivot->regex;

            $inbox->setPattern($attribute, '{' . $pattern . '}');
        }
    }

    protected function registerFallback(): void
    {
        InboxGroup::fallback(fn () => Log::info('Matched no plan.'));
    }
}
