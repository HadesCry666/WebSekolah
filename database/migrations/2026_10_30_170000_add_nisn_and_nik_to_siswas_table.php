<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('siswas', function (Blueprint $table) {
            $table->string('nisn', 20)->nullable()->unique()->after('nis')->comment('Nomor Induk Siswa Nasional');
            $table->string('nik', 25)->nullable()->after('nisn')->comment('Nomor Induk Kependudukan');
        });
    }

    public function down(): void
    {
        Schema::table('siswas', function (Blueprint $table) {
            $table->dropColumn(['nisn', 'nik']);
        });
    }
};
