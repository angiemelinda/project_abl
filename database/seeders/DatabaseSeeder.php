<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Role;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        $this->call([
            RoleSeeder::class,
            UserSeeder::class,
        ]);

        $userRole = Role::where('name', 'user')->first();

        // Hanya buat test user jika belum ada
        if (!User::where('email', 'test@example.com')->exists()) {
            User::factory()->create([
                'name' => 'Test User',
                'email' => 'test@example.com',
                'role_id' => $userRole->id,
            ]);
        }
        
        // Jalankan KonselingSeeder
        $this->call([
            KonselingSeeder::class,
        ]);
    }
}
