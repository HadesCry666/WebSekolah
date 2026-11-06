<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('pengumumans', function (Blueprint $table) {
            $table->id();
            $table->string('judul');
            $table->longText('isi');
            $table->string('lampiran')->nullable();     // path file PDF/doc
            $table->date('tanggal_publikasi');
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('pengumumans');
    }
};
