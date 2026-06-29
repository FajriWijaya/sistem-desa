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
        Schema::create('mutasi_penduduk', function (Blueprint $table) {
            $table->id();
            $table->foreignId('penduduk_id')->constrained('penduduk', 'id')->onDelete('cascade');
            $table->enum('jenis_mutasi', ['pengurangan', 'penambahan']);
            $table->enum('keterangan', ['pindah masuk', 'pindah keluar', 'meninggal', 'kelahiran']);
            $table->date('tanggal_mutasi')->default(now());
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('mutasi_penduduks');
    }
};