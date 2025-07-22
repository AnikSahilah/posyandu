<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('imunisasi', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('id_balita')->nullable(); // Relasi ke pemeriksaan balita
            $table->unsignedBigInteger('id_petugas')->nullable(); // Tambahkan kolom
            $table->date('tanggal_imunisasi');
            $table->unsignedBigInteger('id_jenis')->nullable(); // Relasi ke pemeriksaan balita
            $table->timestamps();

            $table->foreign('id_balita')->references('id')->on('balita')->onDelete('cascade');
            $table->foreign('id_petugas')->references('id')->on('petugas')->onDelete('set null');
            $table->foreign('id_jenis')->references('id')->on('jenis')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('imunisasi');
    }
};
