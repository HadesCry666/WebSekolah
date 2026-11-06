<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (!Schema::hasTable('profil_sekolahs')) {
            Schema::create('profil_sekolahs', function (Blueprint $table) {
                $table->id();
                $table->string('nama_sekolah')->nullable();
                $table->string('npsn')->nullable();
                $table->string('akreditasi')->nullable();
                $table->string('tahun_berdiri')->nullable();
                $table->integer('jumlah_siswa')->default(0);
                $table->string('tagline')->nullable();
                $table->text('deskripsi')->nullable();
                $table->text('sejarah')->nullable();
                $table->text('visi')->nullable();
                $table->text('misi')->nullable();
                $table->string('nama_kepsek')->nullable();
                $table->string('foto_kepsek')->nullable();
                $table->text('sambutan_kepsek')->nullable();
                $table->text('alamat')->nullable();
                $table->string('telepon')->nullable();
                $table->string('email')->nullable();
                $table->string('whatsapp')->nullable();
                $table->string('instagram')->nullable();
                $table->string('youtube')->nullable();
                $table->string('facebook')->nullable();
                $table->text('maps_embed')->nullable();
                $table->text('maps_url')->nullable();
                $table->string('gambar')->nullable();
                $table->string('favicon')->nullable();
                $table->string('logo')->nullable();
                $table->text('meta_description')->nullable();
                $table->timestamps();
            });
        }
    }

    public function down(): void
    {
        Schema::dropIfExists('profil_sekolahs');
    }
};

