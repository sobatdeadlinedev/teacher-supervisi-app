<?php

namespace App\Models;

use Spatie\Permission\Traits\HasRoles;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class User extends Authenticatable
{
    use HasFactory, Notifiable, HasRoles;

    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }
    public function jurnals()
    {
        return $this->hasMany(Jurnal::class);
    }
    public function learningAdministrationFiles()
    {
        return $this->hasMany(LearningAdministrationFile::class);
    }
    public function studentJournals()
    {
        return $this->hasMany(StudentJournal::class, 'user_id');
    }
    /**
     * Relasi: User sebagai Wali Kelas memiliki banyak siswa
     */
    public function siswaBimbingan(): BelongsToMany
    {
        return $this->belongsToMany(
            User::class,
            'wali_kelas_siswa',
            'wali_kelas_id',
            'siswa_id'
        );
    }

    /**
     * Relasi: User sebagai Siswa memiliki wali kelas
     */
    public function waliKelas(): BelongsToMany
    {
        return $this->belongsToMany(
            User::class,
            'wali_kelas_siswa',
            'siswa_id',
            'wali_kelas_id'
        );
    }
}
