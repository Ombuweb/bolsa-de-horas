<?php

namespace Tests\Feature;

use App\Models\Client;
use App\Models\Project;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Str;
use Tests\TestCase;

class ProjectManagementTest extends TestCase
{
    use RefreshDatabase;
    /**
     * @test
     */
    public function a_project_can_be_created()
    {

        $response = $this->post('/projects', [
            'name' => 'ay_obras',
            'client_id' => 1,
        ]);
        $project = Project::first();
        $projects = Project::all();
        $this->assertCount(1, $projects);
        $response->assertRedirect('/projects/' . $project->slug);
    }

    /**
     * @test
     */
    public function only_admin_can_create_project()
    {
        
        Client::factory(2)->create();
        $this->actingAs($user = User::factory()->create([
            'is_admin' => 0,
            'client_id' => Client::first()->id
        ]));

        $response = $this->post('/projects', [
            'name' => 'ay_obras',
            'client_id' => Client::find(2)->id,
        ]);

        $this->assertCount(0, Project::all());
        $response->assertStatus(403);
    }
    /**
     * @test
     */
    public function only_admin_can_see_all_projects()
    {
        
        Client::factory(2)->create();
        $this->actingAs($user = User::factory()->create([
            'is_admin' => 0,
            'client_id' => Client::first()->id
        ]));

        $response = $this->get('/projects');
    
        
        $response->assertStatus(403);
    }
/**
     * @test
     */
    public function only_admin_or_user_from_a_client_can_view_project()
    {
        
        Client::factory(2)->create();
        $this->actingAs($user = User::factory()->create([
            'is_admin' => 1,
            'client_id' => Client::first()->id
        ]));

        $response = $this->post('/projects', [
            'name' => 'ay_obras',
            'client_id' => Client::find(2)->id,
        ]);
        $this->actingAs($user = User::factory()->create([
            'is_admin' => 0,
            'client_id' => Client::first()->id
        ]));
        $project = Project::first();

        $response = $this->get("/projects/$project->slug");

        
        $response->assertStatus(403);
    }
    /**
     * @test
     */
    public function only_admin_can_update_project()
    {
        
        Client::factory(2)->create();
        $this->actingAs($user = User::factory()->create([
            'is_admin' => 1,
            'client_id' => Client::first()->id
        ]));

        $response = $this->post('/projects', [
            'name' => 'ay_obras',
            'client_id' => Client::find(2)->id,
        ]);
        $this->actingAs($user = User::factory()->create([
            'is_admin' => 0,
            'client_id' => Client::first()->id
        ]));
        $project = Project::first();

        $response = $this->patch("/projects/$project->slug", [
            'name' => 'ay_obrasyut',
            'client_id' => Client::find(2)->id,
        ]);

        
        $response->assertStatus(403);
    }
 /**
     * @test
     */
    public function only_admin_can_delete_project()
    {
        
        Client::factory(2)->create();
        $this->actingAs($user = User::factory()->create([
            'is_admin' => 1,
            'client_id' => Client::first()->id
        ]));

        $response = $this->post('/projects', [
            'name' => 'ay_obras',
            'client_id' => Client::find(2)->id,
        ]);
        $this->actingAs($user = User::factory()->create([
            'is_admin' => 0,
            'client_id' => Client::first()->id
        ]));
        $project = Project::first();

        $response = $this->delete("/projects/$project->slug");

        
        $response->assertStatus(403);
    }

    /**
     * @test
     */
    public function a_project_name_is_string_and_required()
    {
        //$this->withoutExceptionHandling();

        $response = $this->post('/projects', [
            'name' => '',
            'client_id' => 1
        ]);
        $response->assertSessionHasErrors('name');
    }

    /**
     * @test
     */
    public function an_id_of_client_for_project_name_integer_and_required()
    {
        //$this->withoutExceptionHandling();

        $response = $this->post('/projects', [
            'name' => 'Jelwey',
            'client_id' => ''
        ]);
        $response->assertSessionHasErrors('client_id');
    }
    /**
     * @test
     */
    public function a_project_can_be_updated()
    {

        $this->post('/projects', [
            'name' => 'Jelwey',
            'client_id' => 1
        ]);
        $project = Project::first();

        $data = [
            'name' => 'Jelwey3',
            'client_id' => 2
        ];
        $response = $this->patch('/projects/' . $project->slug, $data);

        $this->assertEquals('Jelwey3', $project->fresh()->name);
        $this->assertEquals(2, $project->fresh()->client_id);
        $response->assertRedirect('/projects/' . $project->fresh()->slug);
    }
    /**
     * @test
     */
    public function a_unique_can_be_ignored_if_unchanged()
    {
        //$this->withoutExceptionHandling();
        $this->post('/projects', [
            'name' => 'Jelwey',
            'client_id' => 1
        ]);
        $project = Project::first();

        $data = [
            'name' => 'Jelwey',
            'client_id' => 2
        ];
        $response = $this->patch('/projects/' . $project->slug, $data);

        $response->assertSessionHasNoErrors();
    }
    /**
     * @test
     */
    public function a_project_can_be_deleted()
    {

        $this->post('/projects', [
            'name' => 'Jelwey',
            'client_id' => 1
        ]);
        $projects = Project::all();

        $this->assertCount(1, $projects);
        $project = Project::first();
        $response = $this->delete('/projects/' . $project->slug);

        $this->assertCount(0, Project::all());
        $response->assertRedirect('/projects');
    }
}
