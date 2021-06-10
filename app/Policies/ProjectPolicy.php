<?php

namespace App\Policies;

use App\Models\Project;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class ProjectPolicy
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
    public function view (User $user, Project $project)
    {
        return $user->is_admin || ($user->client_id == $project->client_id);
    }
    public function viewAllProjects (User $user)
    {
        return $user->is_admin;
    }
    public function update(User $user)
    {
        return $user->is_admin;
    }
    public function delete(User $user)
    {
        return $user->is_admin;
    }
}
