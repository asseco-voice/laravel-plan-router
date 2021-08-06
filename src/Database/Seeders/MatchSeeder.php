<?php

namespace Asseco\PlanRouter\Database\Seeders;

use Asseco\PlanRouter\App\Contracts\Match;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

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

        if (config('asseco-plan-router.uuid')) {
            foreach ($data as &$item) {
                $item = array_merge($item, [
                    'id' => Str::uuid(),
                ]);
            }
        }

        /** @var Model $match */
        $match = app(Match::class);
        $match::query()->upsert($data, ['name'], ['name']);
    }
}
