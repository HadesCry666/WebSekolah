<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Siswa extends Model
{
    use HasFactory;

    protected $table = 'siswas';

    protected $fillable = [
        'nis',
        'nisn',
        'nik',
        'nama',
        'kelas',
        'jenis_kelamin',
        'tempat_lahir',
        'tanggal_lahir',
        'alamat',
        'nama_wali',
        'kontak_wali',
        'status',
        'foto',
    ];

    protected $casts = [
        'tanggal_lahir' => 'date',
    ];

    // Scope untuk filter status
    public function scopeAktif($query)
    {
        return $query->where('status', 'aktif');
    }

    public function scopeByKelas($query, $kelas)
    {
        return $query->where('kelas', $kelas);
    }

    // Accessor nama kelas lengkap
    public function getJenisKelaminLabelAttribute(): string
    {
        return $this->jenis_kelamin === 'L' ? 'Laki-laki' : 'Perempuan';
    }

    // Accessor umur
    public function getUmurAttribute(): ?int
    {
        return $this->tanggal_lahir
            ? $this->tanggal_lahir->age
            : null;
    }

    public function user()
    {
        return $this->hasOne(User::class, 'siswa_id');
    }

    public function raports()
    {
        return $this->hasMany(Raport::class, 'siswa_id')->orderBy('tahun_ajaran', 'desc')->orderBy('semester', 'desc');
    }
}
