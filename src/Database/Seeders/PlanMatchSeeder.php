<?php

namespace Asseco\PlanRouter\Database\Seeders;

use Asseco\PlanRouter\App\Contracts\Match;
use Asseco\PlanRouter\App\Contracts\Plan;
use Faker\Factory;
use Illuminate\Database\Seeder;

class PlanMatchSeeder extends Seeder
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
        /** @var Match $match */
        $match = app(Match::class);

        $plans = $plan::all();
        $matches = $match::all('id')->pluck('id')->toArray();
        $faker = Factory::create();

        /**
         * @var $plan Plan
         */
        foreach ($plans as $plan) {
            $matchNumber = rand(1, 3);

            $matchRand = [];
            for ($i = 0; $i < $matchNumber; $i++) {
                $matchRand[$matches[array_rand($matches)]] =
                    ['regex' => '.*@' . explode('@', $faker->email)[1]];
            }

            $plan->matches()->sync($matchRand);
        }
    }
}
