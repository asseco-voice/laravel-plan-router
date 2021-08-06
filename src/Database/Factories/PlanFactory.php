<?php

namespace Asseco\PlanRouter\Database\Factories;

use Asseco\PlanRouter\App\Models\Plan;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

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
        $data = [
            'name'         => $this->faker->word,
            'description'  => $this->faker->word,
            'priority'     => $this->faker->numberBetween(0, 100),
            'match_either' => $this->faker->boolean,
            'created_at'   => now(),
            'updated_at'   => now(),
        ];

        if (config('asseco-plan-router.uuid')) {
            $data = array_merge($data, [
                'id' => Str::uuid(),
            ]);
        }

        return $data;
    }
}
