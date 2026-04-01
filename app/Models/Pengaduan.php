<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pengaduan extends Model
{
    // Boleh, tapi sebenernya ini default-nya sudah benar
    protected $table = 'pengaduans';

    protected $fillable = [
        'nama',
        'email',
        'no_hp',
        'judul',
        'isi',
    ];
}
