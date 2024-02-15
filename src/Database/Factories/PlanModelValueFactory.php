<?php

namespace Asseco\PlanRouter\Database\Factories;

use Asseco\PlanRouter\App\Models\Plan;
use Asseco\PlanRouter\App\Models\PlanModelValue;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class PlanModelValueFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = PlanModelValue::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $data = [
            'plan_id' => Plan::factory(),
            'attribute' => $this->faker->word,
            'value' => $this->faker->word,
            'created_at' => now(),
            'updated_at' => now(),
        ];

        if (config('asseco-plan-router.migrations.uuid')) {
            $data = array_merge($data, [
                'id' => Str::uuid(),
            ]);
        }

        return $data;
    }
}
