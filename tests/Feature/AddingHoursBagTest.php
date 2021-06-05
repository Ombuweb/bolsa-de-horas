<?php
//alias ftests="clear && php artisan test --testsuite Feature Tests --filter"
namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\Client;

class AddingHoursBagTest extends TestCase
{
    use RefreshDatabase;
    /**
     * Store test.
     * @test
     * @return void
     */
    public function a_client_and_its_hours_contracted_can_be_added()
    {
        $this->withoutExceptionHandling();
        $response = $this->post('/clients', [
            'name' => 'Amplya',
            'hours' => 100,
        ]);
        $response->assertOk();
        $this->assertCount(1, Client::all());
    }
    /**
     * Validation test
     * @test
     */
    public function title_is_required()
    {
        //$this->withoutExceptionHandling();

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
        //$this->withoutExceptionHandling();

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

        $this->withoutExceptionHandling();

        $this->post('/clients', [
            'name' => 'Amplya',
            'hours' => 100
        ]);
        $clientId= Client::first()->id;

       $this->patch('/clients/'. $clientId, [
            'name' => "Amplya2",
            'hours' => 200
        ]);
        
        $this->assertEquals('Amplya2', Client::first()->name);
        $this->assertEquals(200, Client::first()->hours);

    }
}
