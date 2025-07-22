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
        Schema::create('pemeriksaan_balita', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('id_balita');
            $table->unsignedBigInteger('id_petugas'); // Tambahan relasi ke petugas

            $table->date('tanggal_pemeriksaan');
            $table->integer('umur');
            $table->float('berat_badan');
            $table->float('tinggi_badan');
            $table->string('status');
            $table->timestamps();

            // Foreign key
            $table->foreign('id_balita')->references('id')->on('balita')->onDelete('cascade');
            $table->foreign('id_petugas')->references('id')->on('petugas')->onDelete('cascade'); // Tambahan foreign key
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pemeriksaan_balita');
    }
};
