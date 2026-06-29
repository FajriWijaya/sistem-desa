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


        Schema::create('keluarga', function (Blueprint $table) {
            $table->id();
            $table->string('no_kk')->unique();
            $table->foreignId('kepala_keluarga_id')->constrained('penduduk', 'id')->onDelete('cascade');
            $table->string('alamat');
            $table->foreignId('rt_id')->constrained('rt', 'id')->onDelete('cascade');
            $table->timestamps();
        });

        Schema::create('anggota_keluarga', function (Blueprint $table) {
            $table->id();
            $table->foreignId('keluarga_id')->constrained('keluarga', 'id')->onDelete('cascade');
            $table->foreignId('penduduk_id')->constrained('penduduk', 'id')->onDelete('cascade');
            $table->enum('hubungan', [ '-', 'kepala keluarga', 'istri', 'anak', 'orang tua', 'cucu']); // Contoh: 'kepala keluarga', 'istri', 'anak', dll.
            $table->timestamps();
        });

        Schema::create('kelahiran', function (Blueprint $table) {
            $table->id();
            $table->foreignId('keluarga_id')->constrained('keluarga', 'id')->onDelete('cascade');
            $table->foreignId('ayah_id')->constrained('penduduk', 'id')->onDelete('cascade');
            $table->foreignId('ibu_id')->constrained('penduduk', 'id')->onDelete('cascade');
            $table->foreignId('mutasi_penduduk_id')->constrained('mutasi_penduduk', 'id')->onDelete('cascade');
            $table->string('nama_lengkap');
            $table->enum('jenis_kelamin', ['laki-laki', 'perempuan']);
            $table->string('tempat_lahir');
            $table->date('tanggal_lahir');
            $table->time('waktu_lahir');
            $table->date('tanggal_pelaporan');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('keluargas');
    }
};