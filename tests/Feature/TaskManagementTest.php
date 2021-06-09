<?php

namespace Tests\Feature;

use App\Models\Client;
use App\Models\Project;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use App\Models\Task;
use Faker\Factory;
use Tests\TestCase;

use function PHPUnit\Framework\assertEquals;

class TaskManagementTest extends TestCase
{
    use RefreshDatabase;
    /**
     * @test
     */
    public function a_task_can_be_created()
    {
        $this->withoutExceptionHandling();
        //when task is created, deduct its time from total time contracted by client
        $this->post('/clients', [
            'name' => 'Some client',
            'hours' => 100
        ]);
        $client = Client::first();

        $this->post('/projects', [
            'name' => 'Some project',
            'client_id' => $client->id
        ]);
        $project = Project::first();

        $response = $this->post('/tasks', [
            'project_id' => $project->id,
            'description' => 'Creating a logo',
            'time_spent_on_hours' => 8,
            'time_spent_on_minutes' => 4,
            'time_spent_on_secs' => 3
        ]);

        $this->assertCount(1, Task::all());
        $task = Task::first();
        $response->assertRedirect('/tasks/' . $task->id);
    }

    /**
     * @test
     */
    public function a_task_duration_hours_is_required_and_is_integer()
    {
        //$this->withoutExceptionHandling();
        //when task is created, deduct its time from total time contracted by client
        $this->post('/clients', [
            'name' => 'Some client',
            'hours' => 100
        ]);
        $client = Client::first();

        $this->post('/projects', [
            'name' => 'Some project',
            'client_id' => $client->id
        ]);
        $project = Project::first();

        $response = $this->post('/tasks', [
            'project_id' => $project->id,
            'description' => 'Creating a logo',
            'time_spent_on_hours' => '',
            'time_spent_on_minutes' => 4,
            'time_spent_on_secs' => 3

        ]);

        $this->assertCount(0, Task::all());
        $response->assertSessionHasErrors('time_spent_on_hours');
    }
    /**
     * @test
     */
    public function a_task_duration_minutes_required_and_is_integer()
    {
        //$this->withoutExceptionHandling();
        //when task is created, deduct its time from total time contracted by client
        $this->post('/clients', [
            'name' => 'Some client',
            'hours' => 100
        ]);
        $client = Client::first();

        $this->post('/projects', [
            'name' => 'Some project',
            'client_id' => $client->id
        ]);
        $project = Project::first();

        $response = $this->post('/tasks', [
            'project_id' => $project->id,
            'description' => 'Creating a logo',
            'time_spent_on_hours' => 4,
            'time_spent_on_minutes' => '',
            'time_spent_on_secs' => 3

        ]);

        $this->assertCount(0, Task::all());
        $response->assertSessionHasErrors('time_spent_on_minutes');
    }

    /**
     * @test
     */
    public function a_task_duration_secs_required_and_is_integer()
    {
        //$this->withoutExceptionHandling();
        //when task is created, deduct its time from total time contracted by client
        $this->post('/clients', [
            'name' => 'Some client',
            'hours' => 100
        ]);
        $client = Client::first();

        $this->post('/projects', [
            'name' => 'Some project',
            'client_id' => $client->id
        ]);
        $project = Project::first();

        $response = $this->post('/tasks', [
            'project_id' => $project->id,
            'description' => 'Creating a logo',
            'time_spent_on_hours' => 4,
            'time_spent_on_minutes' => 4,
            'time_spent_on_secs' => ''

        ]);

        $this->assertCount(0, Task::all());
        $response->assertSessionHasErrors('time_spent_on_secs');
    }

    /**
     * @test
     */
    public function an_id_of_project_for_a_task_required_and_is_integer()
    {
        //$this->withoutExceptionHandling();
        //when task is created, deduct its time from total time contracted by client
        $this->post('/clients', [
            'name' => 'Some client',
            'hours' => 100
        ]);
        $client = Client::first();

        $this->post('/projects', [
            'name' => 'Some project',
            'client_id' => $client->id
        ]);
        $project = Project::first();

        $response = $this->post('/tasks', [
            'project_id' => '',
            'description' => 'Creating a logo',
            'time_spent_on_hours' => 4,
            'time_spent_on_minutes' => 4,
            'time_spent_on_secs' => 4

        ]);

        $this->assertCount(0, Task::all());
        $response->assertSessionHasErrors('project_id');
    }
    /**
     * @test
     */
    public function a_task_description_is_required()
    {
        //$this->withoutExceptionHandling();
        //when task is created, deduct its time from total time contracted by client
        $this->post('/clients', [
            'name' => 'Some client',
            'hours' => 100
        ]);
        $client = Client::first();

        $this->post('/projects', [
            'name' => 'Some project',
            'client_id' => $client->id
        ]);
        $project = Project::first();

        $response = $this->post('/tasks', [
            'project_id' => $project->id,
            'description' => '',
            'time_spent_on_hours' => 4,
            'time_spent_on_minutes' => 4,
            'time_spent_on_secs' => 3
        ]);

        $this->assertCount(0, Task::all());
        $response->assertSessionHasErrors('description');
    }


    /**
     * @test
     */
    public function a_task_can_be_updated()
    {
        $this->withoutExceptionHandling();

        $this->post('/clients', [
            'name' => 'Some client',
            'hours' => 100
        ]);
        $client = Client::first();

        $this->post('/projects', [
            'name' => 'Some project',
            'client_id' => $client->id
        ]);
        $project = Project::first();

        $this->post('/tasks', [
            'project_id' => $project->id,
            'description' => 'Creating a logo',
            'time_spent_on_hours' => 4,
            'time_spent_on_minutes' => 4,
            'time_spent_on_secs' => 3
        ]);

        $task = Task::first();

        $this->patch('/tasks/' . $task->id, [
            'project_id' => $project->id,
            'description' => 'Creating a purple logo',
            'time_spent_on_hours' => 4,
            'time_spent_on_minutes' => 4,
            'time_spent_on_secs' => 3

        ]);

        assertEquals('Creating a purple logo', $task->fresh()->description);
    }

    /**
     * @test
     */
    public function a_task_can_be_deleted()
    {
        $this->withoutExceptionHandling();

        $this->post('/clients', [
            'name' => 'Some client',
            'hours' => 100
        ]);
        $client = Client::first();

        $this->post('/projects', [
            'name' => 'Some project',
            'client_id' => $client->id
        ]);
        $project = Project::first();

        $this->post('/tasks', [
            'project_id' => $project->id,
            'description' => 'Creating a logo', 'time_spent_on_hours' => 4,
            'time_spent_on_minutes' => 4,
            'time_spent_on_secs' => 3
        ]);

        $task = Task::first();
        $this->assertCount(1, Task::all());

        $response = $this->delete('/tasks/' . $task->id);
        $this->assertCount(0, Task::all());
        $response->assertRedirect('/tasks');
    }

    /**
     * @test
     */

    public function formatted_project_time_spent_so_far_can_be_obtained()
    {
        $this->withoutExceptionHandling();

        $this->post('/clients', [
            'name' => 'Some client',
            'hours' => 100
        ]);
        $client = Client::first();

        $this->post('/projects', [
            'name' => 'Some project',
            'client_id' => $client->id
        ]);
        $project = Project::first();

        $this->post('/tasks', [
            'project_id' => $project->id,
            'description' => 'Creating a logo',
            'time_spent_on_hours' => 4,
            'time_spent_on_minutes' => 4,
            'time_spent_on_secs' => 3
        ]);

        $this->post('/tasks', [
            'project_id' => $project->id,
            'description' => 'Creating a logo',
            'time_spent_on_hours' => 4,
            'time_spent_on_minutes' => 5,
            'time_spent_on_secs' => 3
        ]);
        
        $seconds = $project->tasks->reduce(function($carry,$d){
            return $carry + $d->time_spent_on_secs;
        });

        $hours = floor($seconds / 3600);
        $mins = floor($seconds / 60 % 60);
        $secs = floor($seconds % 60);
    
        $this->assertCount(2, Task::all());
        $this->assertCount(2, $project->tasks);
        $timePadded = str_pad($hours, 2,'0' ,STR_PAD_LEFT). ':' .str_pad($mins, 2, '0',STR_PAD_LEFT)  . ':' . str_pad($secs, 2,'0',STR_PAD_LEFT);
        $this->assertEquals($timePadded, $project->timeSpentSoFar());
        
    }

    /**
     * @test
     */

    public function total_project_time_spent_so_far_can_be_obtained()
    {
        $this->withoutExceptionHandling();

        $this->post('/clients', [
            'name' => 'Some client',
            'hours' => 100
        ]);
        $client = Client::first();

        $this->post('/projects', [
            'name' => 'Some project',
            'client_id' => $client->id
        ]);
        $project = Project::first();

        $this->post('/tasks', [
            'project_id' => $project->id,
            'description' => 'Creating a logo',
            'time_spent_on_hours' => 4,
            'time_spent_on_minutes' => 4,
            'time_spent_on_secs' => 3
        ]);

        $this->post('/tasks', [
            'project_id' => $project->id,
            'description' => 'Creating a logo',
            'time_spent_on_hours' => 4,
            'time_spent_on_minutes' => 5,
            'time_spent_on_secs' => 3
        ]);
        
        $seconds = $project->tasks->reduce(function($carry,$d){
            return $carry + $d->time_spent_on_secs;
        });

        
    
        $this->assertCount(2, Task::all());
        $this->assertCount(2, $project->tasks);
        $this->assertEquals($seconds, $project->totalTimeSpentSoFar());
        
    }
}
