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
        Schema::create('lapangan', function (Blueprint $table) {
            $table->id('id_lapangan'); // Primary Key custom name
            $table->string('nama_lapangan', 50);
            $table->enum('kategori', ['VIP', 'Reguler']);
            $table->integer('harga_per_jam');
            $table->enum('status_lapangan', ['Tersedia', 'Perawatan']);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('lapangan');
    }
};
