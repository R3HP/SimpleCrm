<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Client>
 */
class ClientFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'contact_name' => fake()->name(),
            'contact_email' => fake()->companyEmail(),
            'contact_phone_number' => fake()->phoneNumber(),
            'company_name' => fake()->company(),
            'company_address' => fake()->address(),
            'company_city' => fake()->city(),
            'company_zip' => fake()->randomNumber(4,true),
            'company_vat' => fake()->randomNumber(3,true),
        ];
    }
}
