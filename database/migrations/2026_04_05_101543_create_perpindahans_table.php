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
        Schema::create('perpindahan', function (Blueprint $table) {
            $table->id();
            $table->foreignId('mutasi_penduduk_id')->constrained('mutasi_penduduk', 'id')->onDelete('cascade');
            $table->enum('jenis_perpindahan', ['pindah masuk', 'pindah keluar']);
            $table->string('alamat_asal')->nullable();
            $table->string('rt_asal')->nullable();
            $table->string('rw_asal')->nullable();
            $table->string('desa_asal')->nullable();
            $table->string('kecamatan_asal')->nullable();
            $table->string('kabupaten_asal')->nullable();
            $table->string('provinsi_asal')->nullable();
            $table->string('rw_tujuan')->nullable();
            $table->string('rt_tujuan')->nullable();
            $table->string('alamat_tujuan')->nullable();
            $table->string('desa_tujuan')->nullable();
            $table->string('kecamatan_tujuan')->nullable();
            $table->string('kabupaten_tujuan')->nullable();
            $table->string('provinsi_tujuan')->nullable();
            $table->string('klasifikasi_perpindahan');
            $table->string('alasan_perpindahan');
            $table->date('tanggal_pelaporan');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('perpindahans');
    }
};