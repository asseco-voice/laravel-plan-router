<?php

namespace Asseco\PlanRouter\Database\Seeders;

use Asseco\PlanRouter\App\Models\Plan;
use Asseco\PlanRouter\App\Models\PlanModelValue;
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
        $plans = Plan::all();

        $values = PlanModelValue::factory()->count(50)->raw([
            'plan_id' => function () use ($plans) {
                return $plans->random()->id;
            },
        ]);

        PlanModelValue::query()->insert($values);
    }
}
