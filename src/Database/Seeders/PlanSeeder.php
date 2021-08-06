<?php

namespace Asseco\PlanRouter\Database\Seeders;

use Asseco\PlanRouter\App\Contracts\Plan;
use Illuminate\Database\Seeder;

class PlanSeeder extends Seeder
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

        $plans = $plan::factory()->count(50)->raw();

        $plan::query()->insert($plans);
    }
}
