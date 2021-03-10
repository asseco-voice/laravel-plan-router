<?php

namespace Asseco\PlanRouter\Database\Seeders;

use Asseco\PlanRouter\App\Models\Match;
use Illuminate\Database\Seeder;

class MatchSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data = [
            ['name' => 'from'],
            ['name' => 'to'],
            ['name' => 'cc'],
            ['name' => 'bcc'],
            ['name' => 'subject'],
        ];

        Match::query()->upsert($data, ['name']);
    }
}
