<?php

namespace Asseco\PlanRouter\Tests\Feature\Http\Controllers;

use Asseco\PlanRouter\App\Models\Plan;
use Asseco\PlanRouter\Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class PlanControllerTest extends TestCase
{
    use RefreshDatabase;

    protected Plan $plan;

    public function setUp(): void
    {
        parent::setUp();

        $this->plan = Plan::factory()->create();
    }

    /**
     * @test
     */
    public function can_get_all_plans()
    {
        $response = $this->getJson(route('plans.index'));

        $response->assertStatus(200)->assertJsonStructure([$this->modelAttributes()]);
    }

    /**
     * @test
     */
    public function can_get_single_plan()
    {
        $response = $this->getJson(route('plans.show', $this->plan->id));

        $response->assertStatus(200)
            ->assertJsonStructure($this->modelAttributes())
            ->assertJson([
                'name' => $this->plan->name,
            ]);
    }

    /**
     * @test
     */
    public function can_create_a_new_plan_if_it_doesnt_exist()
    {
        $plan = Plan::factory()->make();

        $response = $this->postJson(route('plans.store'), [
            'name' => $plan->name,
        ]);

        $response->assertStatus(200)->assertJson([
            'name' => $plan->name,
        ]);
    }

    /**
     * @test
     */
    public function can_update_an_existing_plan()
    {
        $this->withoutExceptionHandling();

        $response = $this->putJson(route('plans.update', $this->plan->id), [
            'name'        => 'test',
            'description' => 'test',
        ]);

        $response->assertStatus(200)->assertJson([
            'name'        => 'test',
            'description' => 'test',
        ]);
    }

    /**
     * @test
     */
    public function can_delete_a_plan()
    {
        $response = $this->deleteJson(route('plans.destroy', $this->plan->id));

        $response->assertStatus(200)->assertSuccessful();
    }

    protected function modelAttributes(): array
    {
        return [
            'id',
            'description',
            'priority',
            'match_either',
            'created_at',
            'updated_at',
        ];
    }
}
