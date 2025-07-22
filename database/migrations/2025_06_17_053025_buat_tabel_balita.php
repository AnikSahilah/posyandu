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
        Schema::create('balita', function (Blueprint $table) {
            $table->id();
            $table->integer('balita_ke');
            $table->float('berat_badan_lahir');
            $table->float('tinggi_lahir');
            $table->string('nik_balita')->nullable();
            $table->string('buku_kia')->nullable();
            $table->string('nama_orang_tua');
            $table->string('nik_orang_tua');
            $table->string('no_hp');
            $table->string('rt');
            $table->string('rw');
            $table->unsignedBigInteger('id_tempat');
            $table->string('nama_balita');
            $table->enum('jenis_kelamin', ['L', 'P']);
            $table->date('tanggal_lahir');
            $table->string('inisiasi_menyusui_dini')->nullable();
            $table->timestamps();

            $table->foreign('id_tempat')->references('id')->on('tempat')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('balita');
    }
};
