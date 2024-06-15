<?php

namespace Database\Factories;

use App\Models\Client;
use App\Models\Project;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Arr;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Task>
 */
class TaskFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $usersIds = collect(User::all()->modelKeys());
        $clientsIds = collect(Client::all()->modelKeys());
        $projectsIds = collect(Project::all()->modelKeys());

        $randomStatus = Arr::random(Project::Status);

        return [    
            'title' => fake()->title(),
            'description' => fake()->text(),
            'deadline' => fake()->date(max:now()->addMonth()),
            'user_id' => $usersIds->random(),
            'client_id' => $clientsIds->random(),
            'project_id' => $projectsIds->random(),
            'status' => $randomStatus,
            'finished_at' => $randomStatus === 'closed' ? fake()->date(max:now()->subUTCDay()) : null,
        ];
    }
}
