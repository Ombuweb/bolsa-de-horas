<?php

namespace Tests\Feature;

use App\Models\Client;
use App\Models\Project;
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
