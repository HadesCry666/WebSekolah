<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Galeri extends Model
{
    use HasFactory;

    protected $table = 'galeris';

    protected $fillable = [
        'judul', 'deskripsi', 'file', 'url_video',
        'tipe', 'kategori', 'urutan', 'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    public function scopeFoto($query)
    {
        return $query->where('tipe', 'foto');
    }

    public function scopeVideo($query)
    {
        return $query->where('tipe', 'video');
    }
}
