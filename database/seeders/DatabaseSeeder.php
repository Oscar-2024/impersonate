<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        User::factory()->create([
            'name' => 'Test User',
            'email' => 'test@example.com',
            'can_impersonate' => true,
            'can_be_impersonated' => false,
        ]);

        User::factory(10)->create([
            'can_impersonate' => false,
            'can_be_impersonated' => true,
        ]);
    }
}
