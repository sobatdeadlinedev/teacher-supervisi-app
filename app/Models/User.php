<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Spatie\Permission\Traits\HasRoles;

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
}
