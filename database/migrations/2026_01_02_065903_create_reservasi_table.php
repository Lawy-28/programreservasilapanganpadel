<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('reservasi', function (Blueprint $table) {
            $table->id('id_reservasi'); // Primary Key custom name

            // Foreign Keys
            $table->foreignId('id_pelanggan')->constrained('pelanggan', 'id_pelanggan');
            $table->foreignId('id_lapangan')->constrained('lapangan', 'id_lapangan');

            $table->date('tanggal');
            $table->time('jam_mulai');
            $table->time('jam_selesai');
            $table->integer('total_bayar');
            $table->enum('status_reservasi', ['Booked', 'Selesai', 'Batal']);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('reservasi');
    }
};
