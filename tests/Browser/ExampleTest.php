<?php

namespace Tests\Browser;

use App\Models\Client;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Laravel\Dusk\Chrome;
use Tests\DuskTestCase;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class ExampleTest extends DuskTestCase
{
    
    use DatabaseMigrations;
   
    public function test_user_gets_redirected_to_login_when_first_visiting_home_page()
    {
        $this->browse(function ($browser) {
            $browser->visit('/login')
                ->assertSee('LOG IN');
            $browser->assertDontSee('Laravel');
            $browser->assertDontSee('Register');
        });
    }

    public function test_user_login_and_if_admin_gets_redirected_to_dashboard()
    {
       
        $this->withoutExceptionHandling();
        
        $client = Client::factory()->create();
        
        $user = User::factory()->create(['is_admin' => 1,'password' => Hash::make('password') , 'client_id' => $client->id,'email' => 'taylor@laravel.com']);
     
        $this->browse(function ($browser) use($user){
            $browser->visit('/')
            ->assertPathIs('/login')
                ->assertSee('LOG IN')
                ->type('email', $user->email)
                ->type('password', 'password')
                ->screenshot('beforeLogin')
                ->click('@login-button')
                ->screenshot('afterLogin')
                ->assertPathIs('/dashboard');
                $browser->assertAuthenticated();

        });
    }

    public function test_user_login_and_if_not_admin_gets_redirected_to_client_his_page()
    {
       
        $this->withoutExceptionHandling();
        
        $client = Client::factory()->create();
        
        $user = User::factory()->create(['is_admin' => 0,'password' => Hash::make('password') , 'client_id' => $client->id,'email' => 'test@laravel.com']);
     
        $this->browse(function ($browser) use($user, $client){
            
            $browser->visit('/')
            ->assertPathIs('/login')
                ->assertSee('LOG IN')
                ->type('email', $user->email)
                ->type('password', 'password')
                ->screenshot('beforeLogin')
                ->click('@login-button')
                ->screenshot('afterLogin')
                ->assertPathIs("/clients/$client->id");
                $browser->assertAuthenticated();

                $browser->assertSee('Clients');

        });
    }
}
