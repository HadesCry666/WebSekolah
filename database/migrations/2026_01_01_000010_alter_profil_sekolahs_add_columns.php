<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('profil_sekolahs', function (Blueprint $table) {

            // Rename judul -> nama_sekolah jika judul ada tapi nama_sekolah belum ada
            if (Schema::hasColumn('profil_sekolahs', 'judul') && !Schema::hasColumn('profil_sekolahs', 'nama_sekolah')) {
                $table->renameColumn('judul', 'nama_sekolah');
            } elseif (!Schema::hasColumn('profil_sekolahs', 'nama_sekolah')) {
                $table->string('nama_sekolah')->nullable();
            }

            // Rename gambar_header -> gambar jika ada
            if (Schema::hasColumn('profil_sekolahs', 'gambar_header') && !Schema::hasColumn('profil_sekolahs', 'gambar')) {
                $table->renameColumn('gambar_header', 'gambar');
            } elseif (!Schema::hasColumn('profil_sekolahs', 'gambar')) {
                $table->string('gambar')->nullable();
            }

            // Tambah kolom-kolom baru
            if (!Schema::hasColumn('profil_sekolahs', 'npsn')) {
                $table->string('npsn')->nullable();
            }
            if (!Schema::hasColumn('profil_sekolahs', 'akreditasi')) {
                $table->string('akreditasi')->nullable();
            }
            if (!Schema::hasColumn('profil_sekolahs', 'tahun_berdiri')) {
                $table->year('tahun_berdiri')->nullable();
            }
            if (!Schema::hasColumn('profil_sekolahs', 'jumlah_siswa')) {
                $table->integer('jumlah_siswa')->nullable();
            }
            if (!Schema::hasColumn('profil_sekolahs', 'tagline')) {
                $table->string('tagline')->nullable();
            }
            if (!Schema::hasColumn('profil_sekolahs', 'sejarah')) {
                $table->longText('sejarah')->nullable();
            }
            if (!Schema::hasColumn('profil_sekolahs', 'nama_kepsek')) {
                $table->string('nama_kepsek')->nullable();
            }
            if (!Schema::hasColumn('profil_sekolahs', 'foto_kepsek')) {
                $table->string('foto_kepsek')->nullable();
            }
            if (!Schema::hasColumn('profil_sekolahs', 'sambutan_kepsek')) {
                $table->text('sambutan_kepsek')->nullable();
            }
            if (!Schema::hasColumn('profil_sekolahs', 'alamat')) {
                $table->string('alamat')->nullable();
            }
            if (!Schema::hasColumn('profil_sekolahs', 'telepon')) {
                $table->string('telepon')->nullable();
            }
            if (!Schema::hasColumn('profil_sekolahs', 'email')) {
                $table->string('email')->nullable();
            }
            if (!Schema::hasColumn('profil_sekolahs', 'whatsapp')) {
                $table->string('whatsapp')->nullable();
            }
            if (!Schema::hasColumn('profil_sekolahs', 'instagram')) {
                $table->string('instagram')->nullable();
            }
            if (!Schema::hasColumn('profil_sekolahs', 'youtube')) {
                $table->string('youtube')->nullable();
            }
            if (!Schema::hasColumn('profil_sekolahs', 'facebook')) {
                $table->string('facebook')->nullable();
            }
            if (!Schema::hasColumn('profil_sekolahs', 'maps_embed')) {
                $table->text('maps_embed')->nullable();
            }
            if (!Schema::hasColumn('profil_sekolahs', 'maps_url')) {
                $table->string('maps_url')->nullable();
            }
            if (!Schema::hasColumn('profil_sekolahs', 'logo')) {
                $table->string('logo')->nullable();
            }
            if (!Schema::hasColumn('profil_sekolahs', 'favicon')) {
                $table->string('favicon')->nullable();
            }
            if (!Schema::hasColumn('profil_sekolahs', 'meta_description')) {
                $table->text('meta_description')->nullable();
            }
        });
    }

    public function down(): void
    {
        Schema::table('profil_sekolahs', function (Blueprint $table) {
            // Rename back
            if (Schema::hasColumn('profil_sekolahs', 'nama_sekolah')) {
                $table->renameColumn('nama_sekolah', 'judul');
            }
            if (Schema::hasColumn('profil_sekolahs', 'gambar') && !Schema::hasColumn('profil_sekolahs', 'gambar_header')) {
                $table->renameColumn('gambar', 'gambar_header');
            }

            $toDrop = ['npsn', 'akreditasi', 'tahun_berdiri', 'jumlah_siswa', 'tagline',
                       'sejarah', 'nama_kepsek', 'foto_kepsek', 'sambutan_kepsek',
                       'alamat', 'telepon', 'email', 'whatsapp', 'instagram',
                       'youtube', 'facebook', 'maps_embed', 'maps_url',
                       'logo', 'favicon', 'meta_description'];

            $existing = array_filter($toDrop, fn($col) => Schema::hasColumn('profil_sekolahs', $col));
            if (!empty($existing)) {
                $table->dropColumn(array_values($existing));
            }
        });
    }
};
