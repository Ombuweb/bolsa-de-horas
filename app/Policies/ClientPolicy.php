<?php

namespace App\Policies;

use App\Models\Client;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class ClientPolicy
{
    use HandlesAuthorization;

    /**
     * Create a new policy instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }
    public function create(User $user)
    {
        return $user->is_admin;
    }
    public function viewAllClients(User $user){
        return $user->is_admin;
    }
    public function view(User $user, Client $client){
        
        return $user->is_admin || ($user->client_id == $client->id);
    }
    public function update(User $user){
        return $user->is_admin;
    }
    public function delete(User $user){
        return $user->is_admin;
    }
}
