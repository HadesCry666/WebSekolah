<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('raports', function (Blueprint $table) {
            $table->id();
            $table->foreignId('siswa_id')->constrained('siswas')->cascadeOnDelete();
            $table->string('tahun_ajaran', 20); // Contoh: 2024/2025
            $table->enum('semester', ['ganjil', 'genap']);
            $table->string('file_raport'); // Path penyimpanan file PDF
            $table->string('nama_file_asli')->nullable();
            $table->boolean('is_published')->default(true);
            $table->text('catatan')->nullable();
            $table->timestamps();

            $table->unique(['siswa_id', 'tahun_ajaran', 'semester']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('raports');
    }
};
