<?php

namespace Asseco\PlanRouter\Database\Seeders;

use Asseco\PlanRouter\App\Contracts\Rule;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class RuleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data = [
            [
                'name' => 'from',
                'label' => 'From',
            ],
            [
                'name' => 'to',
                'label' => 'To',
            ],
            [
                'name' => 'cc',
                'label' => 'Cc',
            ],
            [
                'name' => 'bcc',
                'label' => 'Bcc',
            ],
            [
                'name' => 'subject',
                'label' => 'Subject', ],
        ];

        if (config('asseco-plan-router.migrations.uuid')) {
            foreach ($data as &$item) {
                $item = array_merge($item, [
                    'id' => Str::uuid(),
                ]);
            }
        }

        /** @var Model $rule */
        $rule = app(Rule::class);
        $rule::query()->upsert($data, ['name'], ['name']);
    }
}
