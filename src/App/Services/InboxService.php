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
     * @param CanMatch $canMatch
     * @param bool|null $multipleMatches
     * @return Plan|array|Plan[]|null
     * @throws Exception
     */
    public function match(CanMatch $canMatch, ?bool $multipleMatches = false)
    {
        $this->canMatch = $canMatch;

        $this->registerInboxes();
        $this->registerFallback();

        if (!$multipleMatches) {
            // Interested in first match only as we're not utilizing
            // continuous matching from Inbox package.
            /** @var Inbox $matchedInbox */
            $matchedInbox = Arr::get(InboxGroup::run($canMatch), '0');
            $planId = Arr::get($matchedInbox->getMeta(), 'plan_id');

            /** @var Plan $plan */
            $plan = $this->plan::query()->find($planId);

            return $plan;
        }
        else {
            // MOD: VSLIV30-2578
            // multiple plans could be matched
            $plans = [];
            $matchedInboxes = InboxGroup::run($canMatch, $multipleMatches);

            if (!empty($matchedInboxes)) {
                /** @var Inbox $inbox */
                foreach($matchedInboxes as $inbox) {
                    $planId = Arr::get($inbox->getMeta(), 'plan_id');
                    if ($planId) {
                        /** @var Plan $plan */
                        $plan = $this->plan::query()->find($planId);
                        if ($plan) {
                            $plans[ $plan->id ] = $plan;
                        }
                    }
                }
            }

            return $plans;
        }

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
