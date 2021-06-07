<?php

namespace Asseco\PlanRouter\Tests\Feature\Http\Controllers;

use Asseco\PlanRouter\App\Models\PlanModelValue;
use Asseco\PlanRouter\Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class PlanModelValueControllerTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @test
     */
    public function can_get_all_plan_model_values()
    {
        PlanModelValue::factory()->create();

        $this
            ->getJson(route('plan-model-values.index'))
            ->assertOk()
            ->assertJsonStructure([$this->modelAttributes()]);
    }

    /**
     * @test
     */
    public function can_get_single_plan_model_value()
    {
        $planModelValue = PlanModelValue::factory()->create();

        $this
            ->getJson(route('plan-model-values.show', $planModelValue->id))
            ->assertOk()
            ->assertJsonStructure($this->modelAttributes())
            ->assertJson([
                'attribute' => $planModelValue->attribute,
            ]);
    }

    /**
     * @test
     */
    public function can_create_a_new_plan_model_value_if_it_doesnt_exist()
    {
        $planModelValue = PlanModelValue::factory()->make();

        $this
            ->postJson(route('plan-model-values.store'), $planModelValue->toArray())
            ->assertOk()
            ->assertJson($planModelValue->toArray());
    }

    /**
     * @test
     */
    public function can_update_an_existing_plan_model_value()
    {
        $planModelValue = PlanModelValue::factory()->create();

        $data = [
            'attribute' => 'test',
            'value'     => 'test',
        ];

        $this
            ->putJson(route('plan-model-values.update', $planModelValue->id), $data)
            ->assertOk()
            ->assertJson($data);
    }

    /**
     * @test
     */
    public function can_delete_a_plan_model_value()
    {
        $planModelValue = PlanModelValue::factory()->create();

        $this
            ->deleteJson(route('plan-model-values.destroy', $planModelValue->id))
            ->assertOk()
            ->assertSuccessful();
    }

    protected function modelAttributes(): array
    {
        return [
            'id',
            'plan_id',
            'attribute',
            'value',
            'created_at',
            'updated_at',
        ];
    }
}
