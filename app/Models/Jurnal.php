<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Jurnal extends Model
{
    protected $fillable = [
        'hari_tanggal',
        'kelas',
        'jam_ke',
        'materi_pokok',
        'kegiatan_pembelajaran',
        'penilaian_pembelajaran',
        'kehadiran_peserta_didik',
    ];

    protected $casts = [
        'hari_tanggal' => 'date',
        'kehadiran_peserta_didik' => 'array',
    ];
}
