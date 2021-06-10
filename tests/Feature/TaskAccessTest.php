<?php

namespace Tests\Feature;

use App\Models\Client;
use App\Models\Project;
use App\Models\Task;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class TaskAccessTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @test
     */
    public function only_admin_can_create_task()
    {
        //$this->withoutExceptionHandling();
        Client::factory(2)->create();

        $this->actingAs(User::factory()->create([
            'client_id' => Client::first()->id,
            'is_admin' => 0
        ]));
        $project = Project::factory()->create([
            'client_id' => 2
        ]);
        $taskData = Task::factory()->make([
            'project_id' => $project->id
        ])->getAttributes();
        //dd($taskData->getAttributes());
        $response = $this->post('/tasks', $taskData);
        $response->assertSessionHasNoErrors();
        $this->assertCount(0, Task::all());
        $response->assertStatus(403);
    }

    /**
     * @test
     */
    public function only_admin_or_user_from_a_client_can_view_task()
    {
        $this->withoutExceptionHandling();
        Client::factory(2)->create();

        $this->actingAs(User::factory()->create([
            'client_id' => Client::first()->id,
            'is_admin' => 1
        ]));
        $project = Project::factory()->create([
            'client_id' => 2
        ]);
        $taskData = Task::factory()->make([
            'project_id' => $project->id
        ])->getAttributes();
        //dd($taskData->getAttributes());
        $response = $this->post('/tasks', $taskData);

        $response->assertSessionHasNoErrors();
        $this->assertCount(1, Task::all());

        $task = Task::first();

        $this->actingAs(User::factory()->create([
            'client_id' => 2,
            'is_admin' => 0
        ]));
        $response = $this->get('/tasks/' . $task->id);

        $response->assertViewIs('task');
    }

    /**
     * @test
     */
    public function only_admin_can_update_task()
    {
        //$this->withoutExceptionHandling();
        Client::factory(2)->create();

        $this->actingAs(User::factory()->create([
            'client_id' => Client::first()->id,
            'is_admin' => 1
        ]));
        $project = Project::factory()->create([
            'client_id' => 2
        ]);
        $taskData = Task::factory()->make([
            'project_id' => $project->id
        ])->getAttributes();
        //dd($taskData->getAttributes());
        $this->post('/tasks', $taskData);

        $this->actingAs(User::factory()->create([
            'client_id' => Client::first()->id,
            'is_admin' => 0
        ]));
        $task = Task::first();
        $taskData2 = $taskData;
        $taskData2['description'] = 'hello';
        $response = $this->patch('/tasks/' . $task->id, $taskData2);
        $response->assertSessionHasNoErrors();
        $response->assertStatus(403);
    }

    /**
     * @test
     */
    public function only_admin_can_delete_task()
    {
        //$this->withoutExceptionHandling();
        Client::factory(2)->create();

        $this->actingAs(User::factory()->create([
            'client_id' => Client::first()->id,
            'is_admin' => 1
        ]));
        $project = Project::factory()->create([
            'client_id' => 2
        ]);
        $taskData = Task::factory()->make([
            'project_id' => $project->id
        ])->getAttributes();
        //dd($taskData->getAttributes());
        $this->post('/tasks', $taskData);

        $this->actingAs(User::factory()->create([
            'client_id' => Client::first()->id,
            'is_admin' => 0
        ]));
        $task = Task::first();
        $response = $this->delete('/tasks/' . $task->id);
        $response->assertSessionHasNoErrors();
        $response->assertStatus(403);
    }

    /**
     * @test
     */
    public function only_admin_can_see_all_tasks()
    {
        Client::factory(2)->create();
        $this->actingAs($user = User::factory()->create([
            'is_admin' => 0,
            'client_id' => Client::first()->id
        ]));

        $response = $this->get('/tasks');
    
        
        $response->assertStatus(403);
    }

    

}
