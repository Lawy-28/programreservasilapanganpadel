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
        // Membuat akun Admin
        // Menggunakan firstOrCreate untuk mengecek apakah email sudah ada
        User::firstOrCreate(
            ['email' => 'admin@example.com'], // Kunci pencarian: Jika email ini ditemukan, data tidak akan dibuat ulang
            [
                'name' => 'Administrator', // Nama pengguna
                'password' => bcrypt('password'), // Password yang dienkripsi
                'role' => 'admin', // Peran sebagai admin
            ]
        );

        // Membuat akun Staff
        User::firstOrCreate(
            ['email' => 'staff@example.com'], // Cek email staff
            [
                'name' => 'Staf',
                'password' => bcrypt('password'),
                'role' => 'staff', // Peran sebagai staff
            ]
        );

        // Membuat akun User Baru (Contoh tambahan)
        User::firstOrCreate(
            ['email' => 'abuaqila@gmail.com'], // Cek berdasarkan email agar tidak duplikat
            [
                'name' => 'Abu Aqila',
                'password' => bcrypt('abuaqila28'), // Password khusus untuk user ini
                'role' => 'staff', // Bisa diubah jadi 'admin' atau 'staff' sesuai kebutuhan
            ]
        );
    }
}

