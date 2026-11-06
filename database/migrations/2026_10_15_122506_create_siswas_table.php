<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('siswas', function (Blueprint $table) {
            $table->id();
            $table->string('nis', 20)->unique()->comment('Nomor Induk Siswa');
            $table->string('nama', 100);
            $table->string('kelas', 20)->nullable()->comment('e.g. 7A, 8B, 9C');
            $table->enum('jenis_kelamin', ['L', 'P'])->default('L');
            $table->string('tempat_lahir', 50)->nullable();
            $table->date('tanggal_lahir')->nullable();
            $table->text('alamat')->nullable();
            $table->string('nama_wali', 100)->nullable();
            $table->string('kontak_wali', 20)->nullable();
            $table->enum('status', ['aktif', 'alumni', 'pindah', 'keluar'])->default('aktif');
            $table->string('foto')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('siswas');
    }
};
