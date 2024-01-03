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
        Schema::create('laporan', function (Blueprint $table) {
    
    $table->increments('id_pemagang');
    $table->integer('no');
    $table->date('tgl_hari_ini');
    $table->time('jam_masuk')->nullable();
    $table->time('jam_pulang')->nullable();
    $table->time('jam_istirahat_mulai')->nullable();
    $table->time('jam_istirahat_selesai')->nullable();
    $table->time('jam_izin_mulai')->nullable();
    $table->time('jam_izin_selesai')->nullable();
    $table->time('total_jam_kerja')->nullable();
    $table->enum('status_kehadiran', ['Hadir', 'Izin', 'Tidak Hadir'])->default('Hadir');
    $table->time('ganti_jam')->nullable();
    $table->timestamps();
});

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('laporan');
    }
};