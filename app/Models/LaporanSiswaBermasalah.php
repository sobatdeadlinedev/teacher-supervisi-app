<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LaporanSiswaBermasalah extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'laporan_siswa_bermasalah';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'user_id',
        'kelas',
        'nama_siswa',
        'keadaan_masalah',
        'penanganan',
        'keterangan',
    ];

    /**
     * Get the user (wali kelas) that owns the laporan.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Scope untuk filter berdasarkan bulan
     */
    public function scopeByMonth($query, $month, $year)
    {
        return $query->whereMonth('created_at', $month)
            ->whereYear('created_at', $year);
    }

    /**
     * Scope untuk group by bulan
     */
    public function scopeGroupByMonth($query)
    {
        return $query->selectRaw('YEAR(created_at) as year, MONTH(created_at) as month, COUNT(*) as total')
            ->groupBy('year', 'month')
            ->orderBy('year', 'desc')
            ->orderBy('month', 'desc');
    }
}
