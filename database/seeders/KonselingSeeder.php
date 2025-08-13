<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Konseling;
use App\Models\User;
use Carbon\Carbon;

class KonselingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Pastikan ada user dengan role_id = 3 (user biasa)
        $user = User::where('role_id', 3)->first();
        if (!$user) {
            $this->command->info('Tidak ada user biasa. Menggunakan user test@example.com');
            $user = User::where('email', 'test@example.com')->first();
            
            if (!$user) {
                $this->command->error('User test@example.com tidak ditemukan. Silakan jalankan DatabaseSeeder terlebih dahulu.');
                return;
            }
        }
        
        // Pastikan ada konselor (role_id = 2)
        $konselor = User::where('role_id', 2)->first();
        if (!$konselor) {
            $this->command->error('Tidak ada konselor. Silakan jalankan UserSeeder terlebih dahulu.');
            return;
        }
        
        // Buat data konseling contoh
        Konseling::create([
            'user_id' => $user->id,
            'konselor_id' => $konselor->id,
            'nama_lengkap' => $user->name,
            'email' => $user->email,
            'nomor_telepon' => '08123456789',
            'topik' => 'Konseling Karir',
            'deskripsi' => 'Saya ingin konsultasi mengenai karir di bidang teknologi',
            'jadwal' => Carbon::now()->addDays(2),
            'status' => 'menunggu'
        ]);
        
        Konseling::create([
            'user_id' => $user->id,
            'konselor_id' => $konselor->id,
            'nama_lengkap' => $user->name,
            'email' => $user->email,
            'nomor_telepon' => '08123456789',
            'topik' => 'Konseling Pendidikan',
            'deskripsi' => 'Saya ingin konsultasi mengenai pendidikan lanjutan',
            'jadwal' => Carbon::now()->addDays(3),
            'status' => 'dijadwalkan'
        ]);
        
        $this->command->info('Data konseling berhasil dibuat.');
    }
}