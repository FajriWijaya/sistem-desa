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
        Schema::create('kematians', function (Blueprint $table) {
            $table->id();
            $table->foreignId('mutasi_penduduk_id')->constrained('mutasi_penduduk', 'id')->onDelete('cascade');
            $table->date('tanggal_kematian');
            $table->time('waktu_kematian');
            $table->date('tanggal_pelaporan');          
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('kematians');
    }
};