<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tenaga_pendidik extends Model
{
    use HasFactory;

    protected $fillable = [
        'id',
        'nama',
        'jabatan',
        'foto',
        'NIP',
        'pendidikan_terakhir',
        'mata_pelajaran',
        'agama',
        'alamat',
        'tempat_lahir',
        'tanggal_lahir',
        'jenis_kelamin',
    ];

    public $timestamps = true;

}
