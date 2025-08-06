<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Http;

class TestApiRegistration extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'test:register';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Tests the API registration endpoint.';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('Attempting to register a new user via the API...');

        $response = Http::withHeaders([
            'Content-Type' => 'application/json',
            'Accept' => 'application/json',
        ])->post('http://127.0.0.1:8004/api/register', [
            'name' => 'Pengguna Uji Coba',
            'email' => 'test.' . time() . '@example.com',
            'password' => 'password123',
            'password_confirmation' => 'password123',
        ]);

        $this->info('Status Code: ' . $response->status());
        $this->line('Response Body:');
        $this->line($response->body());

        if ($response->successful()) {
            $this->info('\n\nTest successful! The API registration endpoint is working correctly.');
        } else {
            $this->error('\n\nTest failed. There seems to be an issue with the API endpoint.');
        }

        return 0;
    }
}
