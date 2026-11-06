<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // Add status column to pengaduans
        if (Schema::hasTable('pengaduans') && !Schema::hasColumn('pengaduans', 'status')) {
            Schema::table('pengaduans', function (Blueprint $table) {
                $table->string('status')->default('baru')->after('isi');
            });
        }

        // Add judul and status columns to ekstrakurikulers if not exist
        if (Schema::hasTable('ekstrakurikulers')) {
            Schema::table('ekstrakurikulers', function (Blueprint $table) {
                if (!Schema::hasColumn('ekstrakurikulers', 'judul')) {
                    $table->string('judul')->nullable()->after('id');
                }
                if (!Schema::hasColumn('ekstrakurikulers', 'status')) {
                    $table->boolean('status')->default(true)->after('gambar');
                }
            });
        }

        // Add slug and status to articles
        if (Schema::hasTable('articles')) {
            Schema::table('articles', function (Blueprint $table) {
                if (!Schema::hasColumn('articles', 'slug')) {
                    $table->string('slug')->nullable()->after('judul');
                }
                if (!Schema::hasColumn('articles', 'status')) {
                    $table->string('status')->default('published')->after('kategori');
                }
            });
        }
    }

    public function down(): void
    {
        if (Schema::hasTable('pengaduans') && Schema::hasColumn('pengaduans', 'status')) {
            Schema::table('pengaduans', function (Blueprint $table) {
                $table->dropColumn('status');
            });
        }
        if (Schema::hasTable('ekstrakurikulers')) {
            Schema::table('ekstrakurikulers', function (Blueprint $table) {
                if (Schema::hasColumn('ekstrakurikulers', 'judul')) {
                    $table->dropColumn('judul');
                }
            });
        }
        if (Schema::hasTable('articles')) {
            Schema::table('articles', function (Blueprint $table) {
                if (Schema::hasColumn('articles', 'slug')) {
                    $table->dropColumn('slug');
                }
                if (Schema::hasColumn('articles', 'status')) {
                    $table->dropColumn('status');
                }
            });
        }
    }
};
