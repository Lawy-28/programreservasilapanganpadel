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
     * Menjalankan seeder untuk mengisi database aplikasi.
     */
    public function run(): void
    {
        // Contoh: Membuat 10 user dummy menggunakan factory (sedang dikomentari/tidak aktif)
        // User::factory(10)->create();

    }
}
