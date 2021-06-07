<?php

namespace Asseco\PlanRouter\Database\Seeders;

use Asseco\PlanRouter\App\Models\Plan;
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
        $plans = Plan::factory()->count(50)->raw();

        Plan::query()->insert($plans);
    }
}
