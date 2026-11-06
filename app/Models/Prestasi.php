<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Prestasi extends Model
{
    use HasFactory;

    protected $fillable = [
        'nama', 'kategori', 'tingkat', 'tanggal', 'deskripsi', 'foto', 'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'tanggal' => 'date',
    ];

    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }
}
