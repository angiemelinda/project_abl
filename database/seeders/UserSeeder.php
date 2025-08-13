<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Role;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Pastikan roles sudah ada
        $adminRole = Role::where('name', 'admin')->first();
        $konselorRole = Role::where('name', 'konselor')->first();
        
        if (!$adminRole || !$konselorRole) {
            $this->command->info('Roles tidak ditemukan. Jalankan RoleSeeder terlebih dahulu.');
            return;
        }
        
        // Buat user admin jika belum ada
        if (!User::where('email', 'admin@example.com')->exists()) {
            User::create([
                'name' => 'Administrator',
                'email' => 'admin@example.com',
                'password' => Hash::make('admin123'),
                'role_id' => $adminRole->id,
            ]);
            $this->command->info('User admin berhasil dibuat.');
        }
        
        // Buat user konselor jika belum ada
        if (!User::where('email', 'konselor@example.com')->exists()) {
            User::create([
                'name' => 'Konselor',
                'email' => 'konselor@example.com',
                'password' => Hash::make('konselor123'),
                'role_id' => $konselorRole->id,
            ]);
            $this->command->info('User konselor berhasil dibuat.');
        }
    }
}