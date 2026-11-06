<?php 
    
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProfilSekolah extends Model
{
    protected $fillable = [
        'nama_sekolah', 'npsn', 'akreditasi', 'tahun_berdiri', 'jumlah_siswa',
        'tagline', 'deskripsi', 'sejarah',
        'visi', 'misi',
        'nama_kepsek', 'foto_kepsek', 'sambutan_kepsek',
        'alamat', 'telepon', 'email',
        'whatsapp', 'instagram', 'youtube', 'facebook',
        'maps_embed', 'maps_url',
        'gambar', 'favicon', 'logo', 'meta_description',
    ];
}
