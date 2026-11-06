<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('username', 50)->nullable()->unique()->after('name');
            $table->enum('role', ['admin', 'siswa'])->default('admin')->after('password');
            $table->foreignId('siswa_id')->nullable()->after('role')->constrained('siswas')->nullOnDelete();
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropForeign(['siswa_id']);
            $table->dropColumn(['username', 'role', 'siswa_id']);
        });
    }
};
