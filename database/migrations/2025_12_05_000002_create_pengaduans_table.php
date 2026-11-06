<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (!Schema::hasTable('pengaduans')) {
            Schema::create('pengaduans', function (Blueprint $table) {
                $table->id();
                $table->string('nama');
                $table->string('email')->nullable();
                $table->string('no_hp')->nullable();
                $table->string('judul');
                $table->text('isi');
                $table->enum('status', ['baru', 'proses', 'selesai'])->default('baru');
                $table->timestamps();
            });
        }
    }

    public function down(): void
    {
        Schema::dropIfExists('pengaduans');
    }
};

