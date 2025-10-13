<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class StudentJournal extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'student_number',
        'journal_type',
        'journal_date',
        'journal_data',
    ];

    protected $casts = [
        'journal_date' => 'date',
        'journal_data' => 'array',
    ];

    // Relationship
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    // Constants untuk journal types
    public const TYPE_BANGUN_PAGI = 'bangun_pagi';
    public const TYPE_BERIBADAH = 'beribadah';
    public const TYPE_OLAHRAGA = 'olahraga';
    public const TYPE_MAKAN_SEHAT = 'makan_sehat';
    public const TYPE_BELAJAR = 'belajar';
    public const TYPE_BERMASYARAKAT = 'bermasyarakat';
    public const TYPE_TIDUR_CEPAT = 'tidur_cepat';

    public static function journalTypes(): array
    {
        return [
            self::TYPE_BANGUN_PAGI,
            self::TYPE_BERIBADAH,
            self::TYPE_OLAHRAGA,
            self::TYPE_MAKAN_SEHAT,
            self::TYPE_BELAJAR,
            self::TYPE_BERMASYARAKAT,
            self::TYPE_TIDUR_CEPAT,
        ];
    }
}
