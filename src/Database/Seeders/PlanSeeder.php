<?php

namespace Asseco\PlanRouter\Database\Seeders;

use Asseco\PlanRouter\App\Models\Plan;
use Asseco\PlanRouter\App\Models\PlanTemplate;
use Asseco\PlanRouter\App\Models\SkillGroup;
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
        $planTemplates = PlanTemplate::all('id');
        $skillGroups = SkillGroup::all('id');

        $plans = Plan::factory()->count(50)->raw([
            'template_id'    => function () use ($planTemplates) {
                return rand(0, 100) < 80 ? $planTemplates->random()->id : null;
            },
            'skill_group_id' => function () use ($skillGroups) {
                return $skillGroups->random()->id;
            },
        ]);

        Plan::query()->insert($plans);
    }
}
