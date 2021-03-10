<?php

namespace Asseco\PlanRouter\Database\Factories;

use Asseco\PlanRouter\App\Models\SkillGroup;
use Illuminate\Database\Eloquent\Factories\Factory;

class SkillGroupFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = SkillGroup::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'name'                => $this->faker->word,
            'description'         => $this->faker->word,
            'email'               => $this->faker->email,
            'send_needs_approval' => $this->faker->boolean,
            'created_at'          => now(),
            'updated_at'          => now(),
        ];
    }
}
