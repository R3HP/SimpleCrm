<?php

namespace Database\Factories;

use App\Models\Client;
use App\Models\Project;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Arr;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Project>
 */
class ProjectFactory extends Factory
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

        return [
            'title' => fake()->jobTitle(),
            'description' => fake()->text(),
            'deadline' => fake()->date(max:now()->addYear()),
            'assigned_user' => $usersIds->random(),
            'assigned_client' => $clientsIds->random(),
            'status' => $this->getRandomStatus(),
            // 'status' => Arr::random(Project::Status),
        ];
    }


    private function getRandomStatus() :string{
        switch (random_int(0,3)) {
            case 1:
                return Project::Status[0];
            case 2:
                return last(Project::Status);
            case 3:
                return Project::Status[1];
            default:
            return Project::Status[0];
        }
    }
}
