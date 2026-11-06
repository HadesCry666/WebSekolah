<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('prestasis', function (Blueprint $table) {
            $table->id();
            $table->string('nama');
            $table->string('kategori')->nullable();     // akademik, non-akademik, tahfiz, dll
            $table->string('tingkat')->nullable();       // sekolah, kabupaten, provinsi, nasional
            $table->date('tanggal')->nullable();
            $table->text('deskripsi')->nullable();
            $table->string('foto')->nullable();
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('prestasis');
    }
};
