<?php
//alias ftests="clear && php artisan test --testsuite Feature Tests --filter"
namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\Client;
use App\Models\Project;
use App\Models\User;
use  Illuminate\Auth\Access\AuthorizationException;

class ClientManagementTest extends TestCase
{
    use RefreshDatabase;
    /**
     * Store test.
     * @test
     * @return void
     */
    public function a_client_can_be_created()
    {
        //$this->withoutExceptionHandling();
        $response = $this->post('/clients', [
            'name' => 'Amplya',
            'hours' => 100,
        ]);
        $this->assertCount(1, Client::all());

        $client = Client::first()->slug;
        $response->assertRedirect('/clients/' . $client);
    }
    /**
     * 
     * @test
     */
    public function only_admin_or_user_from_client_can_view_client()
    {
        //$this->withoutExceptionHandling();
        $this->actingAs($user = User::factory()->create([
            'client_id' => 1,
            'is_admin' => 1
        ]));
        $response = $this->post('/clients', [
            'name' => 'Webaliza',
            'hours' => 0,
        ]);
        $this->post('/clients', [
            'name' => 'Amplya',
            'hours' => 100,
        ]);
        $this->assertCount(2, Client::all());

        $this->actingAs($user = User::factory()->create([
            'client_id' => 1,
            'is_admin' => 0
        ]));

        $response = $this->get('/clients/' . $user->client->id);
        //assert return data contains only client for current user or
        //if user is admin, data contains all clients
        $response->assertRedirect('/clients/' . $user->client->slug);
    }

    /**
     * 
     * @test
     */
    public function only_admin_can_view_clients_list()
    {
        
        $this->actingAs($user = User::factory()->create([
            'client_id' => 1,
            'is_admin' => 1
        ]));
        $response = $this->post('/clients', [
            'name' => 'Webaliza',
            'hours' => 0,
        ]);
        $this->post('/clients', [
            'name' => 'Amplya',
            'hours' => 100,
        ]);
        $this->assertCount(2, Client::all());

        $this->actingAs($user = User::factory()->create([
            'client_id' => 1,
            'is_admin' => 0
        ]));

        $response = $this->get('/clients');
        //$this->expectException( AuthorizationException::class);
        //assert return data contains only client for current user or
        //if user is admin, data contains all clients
        $response->assertStatus(403);
    }
    /**
     * 
     * @test
     */
    public function only_admin_user_can_create_client()
    {
        $this->actingAs($user = User::factory()->create([
            'client_id' => 1,
            'is_admin' => 0
        ]));
        $response = $this->post('/clients', [
            'name' => "Amplu",
            'hours' => 100
        ]);
        $this->assertCount(0, Client::all());
        $response->assertStatus(403);
    }
    /**
     * Validation test
     * @test
     */
    public function title_is_required()
    {

        $response = $this->post('/clients', [
            'name' => "",
            'hours' => 100
        ]);

        $response->assertSessionHasErrors('name');
    }

    /**
     * @test
     */
    public function hours_is_required_and_is_integer()
    {
        $response = $this->post('/clients', [
            'name' => "Amplya",
            'hours' => ''
        ]);

        $response->assertSessionHasErrors('hours');
    }
    /**
     * Update test
     * @test
     */

    public function a_client_name_can_be_updated()
    {

        $this->post('/clients', [
            'name' => 'Amplya',
            'hours' => 100
        ]);
        $clientSlug = Client::first();
        $this->assertCount(1, Client::all());
        $response = $this->patch('/clients/' . $clientSlug->slug, [
            'name' => "Amplya",
            'hours' => 200
        ]);

        $response->assertRedirect('/clients/' . $clientSlug->fresh()->slug);
        $this->assertEquals('Amplya', Client::first()->name);
        $this->assertEquals(200, Client::first()->hours);
    }

    /**
     * 
     * @test
     */
    public function only_admin_user_can_update_client()
    {

        $this->actingAs($user = User::factory()->create([
            'client_id' => 1,
            'is_admin' => 1
        ]));
        $response = $this->post('/clients', [
            'name' => "Amplu",
            'hours' => 100
        ]);
        $this->actingAs($user = User::factory()->create([
            'client_id' => 1,
            'is_admin' => 0
        ]));
        $clientSlug = Client::first();
        $response = $this->patch('/clients/' . $clientSlug->slug, [
            'name' => "Amplya",
            'hours' => 200
        ]);
        $response->assertStatus(403);
    }

    /**
     * @test
     */
    public function a_client_can_be_deleted()
    {

        $this->post('/clients', [
            'name' => 'Amplya',
            'slug' => 'amplya',
            'hours' => 100
        ]);

        $this->assertCount(1, Client::all());
        $response = $this->delete('/clients/' . Client::first()->id);
        $response->assertRedirect('/clients');
        $this->assertCount(0, Client::all());
    }
    /**
     * 
     * @test
     */
    public function only_admin_user_can_delete_client()
    {

        $this->actingAs($user = User::factory()->create([
            'client_id' => 1,
            'is_admin' => 1
        ]));
        $response = $this->post('/clients', [
            'name' => "Amplu",
            'hours' => 100
        ]);
        $client = Client::first();
        $this->actingAs($user = User::factory()->create([
            'client_id' => 1,
            'is_admin' => 0
        ]));
        $response = $this->delete('/clients/' . $client->id);
        $response->assertStatus(403);
    }

    /**
     * @test
     */
    public function a_client_can_get_total_time_of_projects()
    {

        $this->withoutExceptionHandling();
        $this->post('/clients', [
            'name' => 'Amplya',
            'slug' => 'amplya',
            'hours' => 100
        ]);
        $client = Client::first();

        $this->post('/projects', [
            'name' => 'Amplya',
            'client_id' => $client->id
        ]);
        $this->post('/projects', [
            'name' => 'Amplya logo',
            'client_id' => $client->id
        ]);
        $project = Project::first();
        $project2 = Project::find(2);
        $this->post('/tasks', [
            'project_id' => $project->id,
            'description' => 'Creating a logo',
            'time_spent_on_hours' => 4,
            'time_spent_on_minutes' => 5,
            'time_spent_on_secs' => 3
        ]);
        $this->post('/tasks', [
            'project_id' => $project2->id,
            'description' => 'Creating a logo',
            'time_spent_on_hours' => 6,
            'time_spent_on_minutes' => 5,
            'time_spent_on_secs' => 3
        ]);
        $this->assertCount(2, $client->projects);
        $this->assertEquals($this->totalTime(4, 5, 3) + $this->totalTime(6, 5, 3), $client->totalTimeSpent());
        $this->assertEquals($this->formattedTotalTime($client->totalTimeSpent()), $client->formattedTotalTimeSpent());
    }

    /**
     * @test
     */

    private function totalTime($hours, $minutes, $seconds)
    {
        return 3600 * $hours + 60 * $minutes + $seconds;
    }

    private function formattedTotalTime($seconds)
    {

        $hours = floor($seconds / 3600);
        $mins = floor($seconds / 60 % 60);
        $secs = floor($seconds % 60);
        return "$hours:$mins:$secs";
    }
}
