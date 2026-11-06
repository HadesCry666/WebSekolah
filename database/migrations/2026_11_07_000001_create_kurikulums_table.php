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
        if (!Schema::hasTable('kurikulums')) {
            Schema::create('kurikulums', function (Blueprint $table) {
                $table->id();
                $table->string('tipe', 50)->default('pilar'); // 'pengantar', 'pilar', 'mapel', 'capaian'
                $table->string('kategori', 50)->nullable();   // 'umum', 'islam', 'sains' (untuk mapel)
                $table->string('judul', 255);
                $table->text('deskripsi')->nullable();
                $table->string('ikon', 100)->nullable();
                $table->text('poin_poin')->nullable();         // Poin bullet dipisah baris baru
                $table->integer('urutan')->default(0);
                $table->boolean('is_active')->default(true);
                $table->timestamps();
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('kurikulums');
    }
};

