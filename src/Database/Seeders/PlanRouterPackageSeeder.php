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
            MatchSeeder::class,
        ]);

        if (config('app.env') !== 'production') {
            $this->call([
                PlanSeeder::class,
                PlanMatchSeeder::class,
            ]);
        }
    }
}
