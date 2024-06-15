<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

        User::factory(5)->create();
        User::factory(3)->deleted()->create();
        
        $admin = User::create([
            'first_name' => 'Admin',
            'last_name' => 'Adminian',
            'email' => 'admin@test.com',
            'password' => Hash::make('password'),
            'email_verified_at' => now(),
            'terms_accepted' => true
        ]);

        $admin->assignRole('admin');

        $user = User::create([
            'first_name' => 'User',
            'last_name' => 'UserPoor',
            'email' => 'tester@test.com',
            'password' => Hash::make('tester'),
            'email_verified_at' => now(),
            'terms_accepted' => false
        ]);

        $user->assignRole('user');
    }
}
