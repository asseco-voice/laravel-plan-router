<?php

namespace Asseco\PlanRouter\Database\Seeders;

use Asseco\PlanRouter\App\Models\SkillGroup;
use Illuminate\Database\Seeder;

class SkillGroupSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        SkillGroup::factory()->count(10)->create();
    }
}
