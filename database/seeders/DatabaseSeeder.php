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
     */
    public function run(): void
    {
        // Membuat user Admin
        User::updateOrCreate(
            ['email' => 'admin@gmail.com'],
            [
                'name' => 'Administrator',
                'password' => bcrypt('admin123'),
                'role' => User::ROLE_ADMIN,
            ]
        );

        // Membuat user Staff
        User::updateOrCreate(
            ['email' => 'staff@gmail.com'],
            [
                'name' => 'Staff Lapangan',
                'password' => bcrypt('staff123'),
                'role' => User::ROLE_STAFF,
            ]
        );

        // Menambahkan data Lapangan
        \DB::table('lapangan')->updateOrInsert(
            ['nama_lapangan' => 'Padel Court 1'],
            [
                'kategori' => 'VIP',
                'harga_per_jam' => 250000,
                'status_lapangan' => 'Tersedia',
                'created_at' => now(),
                'updated_at' => now(),
            ]
        );

        \DB::table('lapangan')->updateOrInsert(
            ['nama_lapangan' => 'Padel Court 2'],
            [
                'kategori' => 'Reguler',
                'harga_per_jam' => 150000,
                'status_lapangan' => 'Tersedia',
                'created_at' => now(),
                'updated_at' => now(),
            ]
        );

        // Menambahkan data Pelanggan
        \DB::table('pelanggan')->updateOrInsert(
            ['nama' => 'Budi Santoso'],
            [
                'no_hp' => '08123456789',
                'email' => 'budi@gmail.com',
                'status' => 'aktif',
                'created_at' => now(),
                'updated_at' => now(),
            ]
        );

        // Opsi: Tambahkan data dummy menggunakan factory jika perlu
        // User::factory(5)->create();
    }
}
