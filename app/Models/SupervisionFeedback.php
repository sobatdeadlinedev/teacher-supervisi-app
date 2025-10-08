<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class SupervisionFeedback extends Model
{
    use HasFactory;

    protected $table = 'supervision_feedbacks';

    protected $fillable = [
        'supervision_id',
        'feedback',
        'rekomendasi',
    ];

    public function supervision()
    {
        return $this->belongsTo(Supervision::class);
    }
}
