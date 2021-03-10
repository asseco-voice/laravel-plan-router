<?php

namespace Asseco\PlanRouter\Database\Factories;

use Asseco\PlanRouter\App\Models\Plan;
use Illuminate\Database\Eloquent\Factories\Factory;

class PlanFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Plan::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'name'           => $this->faker->word,
            'description'    => $this->faker->word,
            'priority'       => $this->faker->numberBetween(0, 100),
            'match_either'   => $this->faker->boolean,
            'template_id'    => null,
            'skill_group_id' => null,
            'created_at'     => now(),
            'updated_at'     => now(),
        ];
    }
}
