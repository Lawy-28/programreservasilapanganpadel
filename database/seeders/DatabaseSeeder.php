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
        // User::factory(10)->create(); // Kode bawaan (dimatikan) contoh buat 10 user random

        // Memanggil UserSeeder
        // Ini akan menjalankan file UserSeeder.php untuk membuat akun Admin dan Staff default
        $this->call(UserSeeder::class);
    }
}
