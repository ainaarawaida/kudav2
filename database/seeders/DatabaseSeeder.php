<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        $user = User::factory()->create([
            'name' => 'admin',
            'email' => 'admin@admin.test',
            'password' => Hash::make('admin'),
        ]);

        $this->call([
            UserSeeder::class,
            HorseSeeder::class,
            TimeSeeder::class,
            RoleSeeder::class,
            RiderSeeder::class,
            CoachSeeder::class

        ]);
    }
}
