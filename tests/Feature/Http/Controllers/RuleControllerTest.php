<?php

namespace Asseco\PlanRouter\Tests\Feature\Http\Controllers;

use Asseco\PlanRouter\App\Models\Rule;
use Asseco\PlanRouter\Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class RuleControllerTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @test
     */
    public function can_get_all_rules()
    {
        Rule::factory()->create();

        $response = $this->getJson(route('rules.index'));

        $response->assertStatus(200)->assertJsonStructure([$this->modelAttributes()]);
    }

    protected function modelAttributes(): array
    {
        return [
            'id',
            'name',
            'created_at',
            'updated_at',
        ];
    }
}
