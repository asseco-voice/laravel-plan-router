<?php

namespace Asseco\PlanRouter\Database\Factories;

use Asseco\PlanRouter\App\Models\Rule;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class RuleFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Rule::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $data = [
            'name' => $this->faker->unique()->word,
            'label' => $this->faker->word,
        ];

        if (config('asseco-plan-router.migrations.uuid')) {
            $data = array_merge($data, [
                'id' => Str::uuid(),
            ]);
        }

        return $data;
    }
}
