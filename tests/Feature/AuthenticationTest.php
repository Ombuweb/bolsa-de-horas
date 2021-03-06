<?php

namespace Tests\Feature;

use App\Models\Client;
use App\Models\User;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Auth;
use Tests\TestCase;

class AuthenticationTest extends TestCase
{
    use RefreshDatabase;

    public function test_login_screen_can_be_rendered()
    {
        $response = $this->get('/login');

        $response->assertStatus(200);
    }

    public function test_users_can_authenticate_using_the_login_screen()
    {
        $this->withoutExceptionHandling();
        $user = User::factory()->create([
            'is_admin' => 0,
            'client_id' => Client::factory()->create()->id
        ]);

        $response = $this->post('/login', [
            'email' => $user->email,
            'password' => 'password',
        ]);

        $this->assertAuthenticated();
        if(Auth::user()->is_admin){
            $response->assertRedirect('/clients/');
        }
        if(!Auth::user()->is_admin){
            return redirect('/clients/'.Auth::user()->client_id);
        }
        //$response->assertRedirect(RouteServiceProvider::HOME);
    }

    public function test_users_can_not_authenticate_with_invalid_password()
    {
        $user = User::factory()->create();

        $this->post('/login', [
            'email' => $user->email,
            'password' => 'wrong-password',
        ]);

        $this->assertGuest();
    }

    public function test_user_is_redirected_to_login_page_when_visit_home(){
        $response = $this->get('/');
        $response->assertRedirect('/login');
    }
}
