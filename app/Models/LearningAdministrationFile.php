<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LearningAdministrationFile extends Model
{
    protected $table = 'learning_administration_files';

    protected $fillable = [
        'user_id',
        'file_type',
        'mata_pelajaran',
        'kelas',
        'semester',
        'tahun_ajaran',
        'original_filename',
        'stored_filename',
        'file_path',
        'mime_type',
        'file_size',
        'description',
        'status',
        'feedback',
    ];

    protected $casts = [
        'tahun_ajaran' => 'integer',
        'file_size' => 'integer',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
