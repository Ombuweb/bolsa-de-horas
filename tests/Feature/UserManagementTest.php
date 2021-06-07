<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class UserManagementTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @test
     */
    public function a_user_can_be_created()
    {
        //client_id will be provided in a select
        //$this->withoutExceptionHandling();
        $response = $this->post('/register',[
            'name' => 'John Doe',
            'client_id' => 1,
            'is_admin' => true,
            'email' => "johndoe@gmail.com",
            'password' => '12345678',
            'password_confirmation' => '12345678'
        ]);

        $this->assertCount(1,User::all());
        $this->assertAuthenticated();

    }

    /**
     * @test
     */
    public function a_name_of_user_from_client_is_required(){
        //$this->withoutExceptionHandling();
        $response = $this->post('/register',[
            'name' => '',
            'client_id' => 1,
            'is_admin' => true,
            'email' => "johndoe@gmail.com",
            'password' => '12345678',
            'password_confirmation' => '12345678'
        ]);
        $response->assertSessionHasErrors('name');
    }
    /**
     * @test
     */
    public function a_name_of_user_from_client_is_string(){
        //$this->withoutExceptionHandling();
        $response = $this->post('/register',[
            'name' => 123456,
            'client_id' => 1,
            'is_admin' => true,
            'email' => "johndoe@gmail.com",
            'password' => '12345678',
            'password_confirmation' => '12345678'
        ]);
        $response->assertSessionHasErrors('name');
    }
    /**
     * @test
     */
    public function an_id_of_client_a_user_belongs_to_is_required(){
        //$this->withoutExceptionHandling();
        $response = $this->post('/register',[
            'name' => 'John Doe',
            'client_id' => '',
            'is_admin' => true,
            'email' => "johndoe@gmail.com",
            'password' => '12345678',
            'password_confirmation' => '12345678'
        ]);
        $response->assertSessionHasErrors('client_id');
    }
    /**
     * @test
     */
    public function an_id_of_client_a_user_belongs_to_is_an_integer(){
        //$this->withoutExceptionHandling();
        $response = $this->post('/register',[
            'name' => 'John Doe',
            'client_id' => 'y',
            'is_admin' => true,
            'email' => "johndoe@gmail.com",
            'password' => '12345678',
            'password_confirmation' => '12345678'
        ]);
        $response->assertSessionHasErrors('client_id');
    }
     /**
     * @test
     */
    public function a_user_admin_status_is_a_boolean(){
        //$this->withoutExceptionHandling();
        $response = $this->post('/register',[
            'name' => 'John Doe',
            'client_id' => 1,
            'is_admin' => 'true',
            'email' => "johndoe@gmail.com",
            'password' => '12345678',
            'password_confirmation' => '12345678'
        ]);
        $response->assertSessionHasErrors('is_admin');
    }
      /**
     * @test
     */
    public function a_user_email_is_required(){
        //$this->withoutExceptionHandling();
        $response = $this->post('/register',[
            'name' => 'John Doe',
            'client_id' => 1,
            'is_admin' => true,
            'email' => "",
            'password' => '12345678',
            'password_confirmation' => '12345678'
        ]);
        $response->assertSessionHasErrors('email');
    }
      /**
     * @test
     */
    public function a_user_email_is_valid(){
        //$this->withoutExceptionHandling();
        $response = $this->post('/register',[
            'name' => 'John Doe',
            'client_id' => 1,
            'is_admin' => true,
            'email' => "dfdfrrfd",
            'password' => '12345678',
            'password_confirmation' => '12345678'
        ]);
        $response->assertSessionHasErrors('email');
    }

    //test if email is unique

       /**
     * @test
     */
    public function a_user_password_is_required(){
        //$this->withoutExceptionHandling();
        $response = $this->post('/register',[
            'name' => 'John Doe',
            'client_id' => 1,
            'is_admin' => true,
            'email' => "dfdfrrfd",
            'password' => '',
            'password_confirmation' => '12345678'
        ]);
        $response->assertSessionHasErrors('password');
    }
       /**
     * @test
     */
    public function a_user_password_is_atleast_8_characters(){
        //$this->withoutExceptionHandling();
        $response = $this->post('/register',[
            'name' => 'John Doe',
            'client_id' => 1,
            'is_admin' => true,
            'email' => "dfdfrrfd",
            'password' => '123456',
            'password_confirmation' => '12345678'
        ]);
        $response->assertSessionHasErrors('password');
    }

       /**
     * @test
     */
    public function a_user_passwordConfirmatioin_is_required_and_matches(){
        //$this->withoutExceptionHandling();
        $response = $this->post('/register',[
            'name' => 'John Doe',
            'client_id' => 1,
            'is_admin' => true,
            'email' => "dfdfrrfd",
            'password' => '12345678',
            'password_confirmation' => ''
        ]);
        $response->assertSessionHasErrors('password');
    }
}
