<?php

namespace Asseco\PlanRouter\Database\Seeders;

use Asseco\PlanRouter\App\Contracts\Plan;
use Asseco\PlanRouter\App\Contracts\PlanModelValue;
use Illuminate\Database\Seeder;

class PlanModelValueSeeder extends Seeder
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
        /** @var PlanModelValue $planModelValue */
        $planModelValue = app(PlanModelValue::class);

        $plans = $plan::all();

        $values = $planModelValue::factory()->count(50)->raw([
            'plan_id' => function () use ($plans) {
                return $plans->random()->id;
            },
        ]);

        $planModelValue::query()->insert($values);
    }
}
