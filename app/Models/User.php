<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use Notifiable;

    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
        'phone',
        'date_of_birth',
        'address',
        'is_active'
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
        'is_active' => 'boolean',
        'date_of_birth' => 'date',
    ];

    public function isAdmin()
    {
        return $this->role === 'admin';
    }

    public function examAttempts()
    {
        return $this->hasMany(ExamAttempt::class);
    }

    public function results()
    {
        return $this->hasMany(Result::class);
    }
}
