<?php

namespace Asseco\PlanRouter\Database\Factories;

use Asseco\PlanRouter\App\Models\Plan;
use Asseco\PlanRouter\App\Models\PlanModelValue;
use Illuminate\Database\Eloquent\Factories\Factory;

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
        return [
            'plan_id'    => Plan::factory(),
            'attribute'  => $this->faker->word,
            'value'      => $this->faker->word,
            'created_at' => now(),
            'updated_at' => now(),
        ];
    }
}
