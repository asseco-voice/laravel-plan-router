<?php

namespace Asseco\PlanRouter\Database\Seeders;

use Illuminate\Database\Seeder;

class SkillGroupPackageSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->call([
            MatchSeeder::class,
            PlanTemplateSeeder::class,
            PlanSeeder::class,
            PlanModelValuesSeeder::class,
            PlanMatchSeeder::class,
            PlanTemplateModelSeeder::class,
        ]);

    }
}
