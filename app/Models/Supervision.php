<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Supervision extends Model
{
    use HasFactory;

    protected $fillable = [
        'guru_id',
        'supervisor_id',
        'schedule_date',
        'schedule_time',
        'status',
        'mata_pelajaran',
        'kelas',
        'notes',
    ];

    protected $casts = [
        'schedule_date' => 'date',
    ];

    public function guru()
    {
        return $this->belongsTo(User::class, 'guru_id');
    }

    public function supervisor()
    {
        return $this->belongsTo(User::class, 'supervisor_id');
    }

    public function assessments()
    {
        return $this->hasMany(SupervisionAssessment::class);
    }

    public function feedbacks()
    {
        return $this->hasMany(SupervisionFeedback::class);
    }
}
