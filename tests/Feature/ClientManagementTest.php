<?php
//alias ftests="clear && php artisan test --testsuite Feature Tests --filter"
namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\Client;

use function PHPUnit\Framework\assertEquals;

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
        $this->withoutExceptionHandling();
        $response = $this->post('/clients', [
            'name' => 'Amplya',
            'slug' => 'amplya',
            'hours' => 100,
        ]);

        $client = Client::first()->slug;
        $this->assertCount(1, Client::all());
        $response->assertRedirect('/clients/' . $client);
    }
    /**
     * Validation test
     * @test
     */
    public function title_is_required()
    {

        $response = $this->post('/clients', [
            'name' => "",
            'slug'=>'amplya',
            'hours' => 100
        ]);

        $response->assertSessionHasErrors('name');
    }
    /**
     * @test
     */
    public function a_slug_is_required_and_unique()
    {
        //$this->withoutExceptionHandling();
        $response = $this->post('/clients',[
            'name' => 'Amplya',
            'slug' => '',
            'hours' => 100
        ]);

        $response->assertSessionHasErrors('slug');
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
            'slug' => 'amplya',
            'hours' => 100
        ]);
        $clientSlug = Client::first();

        $response = $this->patch('/clients/' . $clientSlug->slug, [
            'name' => "Amplya2",
            'slug' => "amplya2",
            'hours' => 200
        ]);
        $response->assertRedirect('/clients/' . $clientSlug->fresh()->slug);
        $this->assertEquals('Amplya2', Client::first()->name);
        $this->assertEquals(200, Client::first()->hours);
    }

    /**
     * @test
     */
    public function a_client_can_be_deleted()
    {
        $this->withoutExceptionHandling();

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


}
