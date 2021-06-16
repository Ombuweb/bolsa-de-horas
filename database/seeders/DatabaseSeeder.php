<?php

namespace Database\Seeders;

use App\Models\Client;
use App\Models\Project;
use App\Models\Task;
use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $client1 = Client::factory()->create();
        User::factory()->create([
            'client_id' => $client1->id,
            'is_admin' => 1,
            'password' => Hash::make('password') ,
            'email' => 'test@gmail.com'
        ]);

        $client2 = Client::factory()->create();
        User::factory()->create([
            'client_id' => $client2->id,
            'is_admin' => 0
        ]);

        $project = Project::factory()->create([
            'client_id' => $client2->id,
        ]);
        Task::create([
            'project_id' => $project->id,
            'description' => "dfhdskja dsfljsa fsfusoa fsdjofa fdlfdsfdso",
            'time_spent_on_secs' => 5678
        ]);
    }
}
