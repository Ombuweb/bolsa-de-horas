<?php

namespace App\Policies;

use App\Models\Task;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class TaskPolicy
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
    public function view (User $user, Task $task)
    {
        return $user->is_admin || ($user->client_id == $task->project->client_id);
    }
    public function viewAllTasks (User $user)
    {
        return $user->is_admin;
    }
    public function create(User $user){
        return $user->is_admin;
    }
    public function update(User $user){
        return $user->is_admin;
    }
    public function delete(User $user){
        return $user->is_admin;
    }
}
