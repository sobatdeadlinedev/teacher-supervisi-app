<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class SupervisionAssessment extends Model
{
    use HasFactory;

    protected $table = 'supervision_assessments';

    protected $fillable = [
        'supervision_id',
        'assessment_type',
        'assessment_data',
    ];

    protected $casts = [
        'assessment_data' => 'array',
    ];

    public function supervision()
    {
        return $this->belongsTo(Supervision::class);
    }
}
