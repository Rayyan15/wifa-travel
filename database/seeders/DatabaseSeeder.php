<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        User::updateOrCreate(
            ['email' => 'admin@wifatour.com'],
            [
                'name' => 'Administrator Wifa',
                'password' => bcrypt('password123'),
                'role' => 'superadmin',
            ]
        );

        User::updateOrCreate(
            ['email' => 'sales@wifatour.com'],
            [
                'name' => 'Tim Sales Wifa',
                'password' => bcrypt('password123'),
                'role' => 'sales',
            ]
        );
    }
}
