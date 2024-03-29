<?php

namespace Asseco\PlanRouter\Database\Seeders;

use Illuminate\Database\Seeder;

class PlanRouterPackageSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->call([
            PlanSeeder::class,
            PlanRuleSeeder::class,
            PlanModelValueSeeder::class,
        ]);
    }
}
