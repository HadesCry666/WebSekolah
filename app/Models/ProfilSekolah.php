<?php 
    
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProfilSekolah extends Model
{
    protected $fillable = [
        'nama_sekolah',
        'tagline',
        'deskripsi',
        'visi',
        'misi',
        'alamat',
        'telepon',
        'email',
        'gambar',
    ];
}
