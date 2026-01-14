<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Menjalankan database seeds (pengisian data awal).
     */
    public function run(): void
    {

        // Membuat akun Staff
        // firstOrCreate: Cek apakah data dengan email tersebut sudah ada.
        // Jika belum ada, buat baru. Jika sudah ada, jangan lakukan apa-apa.
        // Ini berguna agar seeder tidak error jika dijalankan berulang kali (idempotent).
        User::firstOrCreate(
            ['email' => 'staff@example.com'], // Kunci pencarian (Search Key)
            [
                'name' => 'Staf',                 // Data yang akan diisi jika baru dibuat
                'password' => bcrypt('password'), // Hash password
                'role' => 'staff',                // Set sebagai staff
            ]
        );

        // Membuat akun User Tambahan (Contoh)
        User::firstOrCreate(
            ['email' => 'abuaqila@gmail.com'],
            [
                'name' => 'Abu Aqila',
                'password' => bcrypt('abuaqila28'),
                'role' => 'staff',
            ]
        );
    }
}

