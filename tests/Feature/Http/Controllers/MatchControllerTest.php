<?php

namespace Asseco\PlanRouter\Tests\Feature\Http\Controllers;

use Asseco\PlanRouter\App\Models\Match;
use Asseco\PlanRouter\Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class MatchControllerTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @test
     */
    public function can_get_all_matches()
    {
        Match::factory()->create();

        $response = $this->getJson(route('matches.index'));

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
