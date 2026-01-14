<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     * Menjalankan migrasi untuk membuat tabel 'reservasi'.
     */
    public function up(): void
    {
        Schema::create('reservasi', function (Blueprint $table) {
            // Primary Key dengan nama kustom 'id_reservasi'
            $table->id('id_reservasi');

            // Foreign Keys (Kunci Asing)
            // Menghubungkan ke tabel 'pelanggan' kolom 'id_pelanggan'
            $table->foreignId('id_pelanggan')->constrained('pelanggan', 'id_pelanggan');

            // Menghubungkan ke tabel 'lapangan' kolom 'id_lapangan'
            $table->foreignId('id_lapangan')->constrained('lapangan', 'id_lapangan');

            // Data tanggal reservasi
            $table->date('tanggal');

            // Waktu mulai main
            $table->time('jam_mulai');

            // Waktu selesai main
            $table->time('jam_selesai');

            // Total biaya yang harus dibayar
            $table->integer('total_bayar');

            // Status reservasi: Booked, Selesai, atau Batal
            $table->enum('status_reservasi', ['Booked', 'Selesai', 'Batal']);

            // Kolom created_at dan updated_at otomatis
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     * Membatalkan migrasi (menghapus tabel).
     */
    public function down(): void
    {
        Schema::dropIfExists('reservasi');
    }
};
