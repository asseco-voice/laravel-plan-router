<?php

namespace Asseco\PlanRouter\Tests\Feature\Http\Controllers;

use Asseco\PlanRouter\App\Models\SkillGroup;
use Asseco\PlanRouter\Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class SkillGroupControllerTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @test
     */
    public function can_get_all_skill_groups()
    {
        SkillGroup::factory()->create();

        $response = $this->getJson(route('skill-groups.index'));

        $response->assertStatus(200)->assertJsonStructure([$this->modelAttributes()]);
    }

    /**
     * @test
     */
    public function can_get_single_skill_group()
    {
        $skillGroup = SkillGroup::factory()->create();

        $response = $this->getJson(route('skill-groups.show', $skillGroup->id));

        $response->assertStatus(200)
            ->assertJsonStructure($this->modelAttributes())
            ->assertJson([
                'name' => $skillGroup->name,
            ]);
    }

    /**
     * @test
     */
    public function can_create_a_new_skill_group_if_it_doesnt_exist()
    {
        $this->withoutExceptionHandling();
        $skillGroup = SkillGroup::factory()->make();

        $response = $this->postJson(route('skill-groups.store'), [
            'name'  => $skillGroup->name,
            'email' => $skillGroup->email,
        ]);

        $response->assertStatus(200)->assertJson([
            'name'  => $skillGroup->name,
            'email' => $skillGroup->email,
        ]);
    }

    /**
     * @test
     */
    public function can_update_an_existing_skill_group()
    {
        $skillGroup = SkillGroup::factory()->create();

        $response = $this->putJson(route('skill-groups.update', $skillGroup->id), [
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
    public function can_delete_a_skill_group()
    {
        $skillGroup = SkillGroup::factory()->create();

        $response = $this->deleteJson(route('skill-groups.destroy', $skillGroup->id));

        $response->assertStatus(200)->assertSuccessful();
    }

    protected function modelAttributes(): array
    {
        return [
            'id',
            'name',
            'description',
            'email',
            'sender_name',
            'reply_to',
            'priority',
            'send_needs_approval',
            'created_at',
            'updated_at',
        ];
    }
}
