<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Ekstrakurikuler extends Model
{
    protected $fillable = [
        'deskripsi',
        'gambar',
        'status',
        'judul',
    ];

    // cast status ke boolean
    protected $casts = [
        'status' => 'boolean',
    ];
}
