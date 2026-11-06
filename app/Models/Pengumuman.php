<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pengumuman extends Model
{
    use HasFactory;

    protected $table = 'pengumumans';

    protected $fillable = [
        'judul', 'isi', 'lampiran', 'tanggal_publikasi', 'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'tanggal_publikasi' => 'date',
    ];

    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    public function scopePublished($query)
    {
        return $query->where('tanggal_publikasi', '<=', now()->toDateString());
    }
}
