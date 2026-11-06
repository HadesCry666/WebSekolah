<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Raport extends Model
{
    use HasFactory;

    protected $table = 'raports';

    protected $fillable = [
        'siswa_id',
        'tahun_ajaran',
        'semester',
        'file_raport',
        'nama_file_asli',
        'is_published',
        'catatan',
    ];

    protected $casts = [
        'is_published' => 'boolean',
    ];

    public function siswa(): BelongsTo
    {
        return $this->belongsTo(Siswa::class, 'siswa_id');
    }

    public function getSemesterLabelAttribute(): string
    {
        return ucfirst($this->semester);
    }
}
