<?php

namespace Asseco\PlanRouter\Database\Seeders;

use Asseco\PlanRouter\App\Contracts\Rule;
use Asseco\PlanRouter\App\Contracts\Plan;
use Faker\Factory;
use Illuminate\Database\Seeder;

class PlanRuleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        /** @var Plan $plan */
        $plan = app(Plan::class);
        /** @var Rule $rule */
        $rule = app(Rule::class);

        $plans = $plan::all();
        $rules = $rule::all('id')->pluck('id')->toArray();
        $faker = Factory::create();

        /**
         * @var $plan Plan
         */
        foreach ($plans as $plan) {
            $ruleNumber = rand(1, 3);

            $ruleRand = [];
            for ($i = 0; $i < $ruleNumber; $i++) {
                $ruleRand[$rules[array_rand($rules)]] =
                    ['regex' => '.*@' . explode('@', $faker->email)[1]];
            }

            $plan->rules()->sync($ruleRand);
        }
    }
}
