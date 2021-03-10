<?php

namespace Asseco\PlanRouter\Database\Seeders;

use Asseco\PlanRouter\App\Models\PlanTemplate;
use Illuminate\Database\Seeder;

class PlanTemplateSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        PlanTemplate::factory()->count(10)->create();
    }
}
