<?php

namespace Tests\Feature;

use App\Models\Project;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ProjectManagementTest extends TestCase
{
    use RefreshDatabase;
    /**
     * @test
     */
    public function a_project_can_be_created()
    {
        $this->withoutExceptionHandling();
        $response = $this->post('/projects', [
            'name' => 'ay_obras',
            'client_id' => 1
        ]);
        $projects = Project::all();
        $this->assertCount(1, $projects);
        $response->assertStatus(200);
    }
}
