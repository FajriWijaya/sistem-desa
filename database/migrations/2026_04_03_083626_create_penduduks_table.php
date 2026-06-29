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
        Schema::create('dusun', function (Blueprint $table) {
            $table->id();
            $table->string('nama_dusun');
            $table->timestamps();
        });

        Schema::create('rw', function (Blueprint $table) {
            $table->id();
            $table->foreignId('dusun_id')->constrained('dusun')->onDelete('cascade');
            $table->string('ketua_rw');
            $table->string('no_rw');
            $table->timestamps();
        });

        Schema::create('rt', function (Blueprint $table) {
            $table->id();
            $table->foreignId('rw_id')->constrained('rw')->onDelete('cascade');
            $table->string('ketua_rt');
            $table->string('no_rt');
            $table->timestamps();
        });

        Schema::create('penduduk', function (Blueprint $table) {
            $table->id();
            $table->string('nik')->unique();
            $table->string('nama_lengkap');
            $table->enum('jenis_kelamin', ['laki-laki', 'perempuan']);
            $table->string('alamat');
            $table->string('tempat_lahir');
            $table->date('tanggal_lahir');
            $table->string('nama_ibu');
            $table->string('nama_ayah');
            $table->foreignId('rt_id')->constrained('rt')->onDelete('cascade');
            $table->string('agama');
            $table->string('profesi');
            $table->string('pendidikan');
            $table->string('status_kependudukan')->default('aktif');
            $table->enum('status_perkawinan', ['Belum Menikah', 'Menikah', 'Cerai Mati', 'Cerai Hidup']);
            $table->enum('golongan_darah', ['A', 'B', 'AB', 'O', '-']);
            $table->enum('kewarganegaraan', ['WNI', 'WNA']);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('penduduks');
    }
};