<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

   protected $fillable = [
    'name',
    'student_id',
    'profile_photo',
    'email',
    'password',
    'role',
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

    // Helper: check if user is admin
    public function isAdmin(): bool
    {
        return $this->role === 'admin';
    }

    public function isStudent()
{
    return $this->role === 'student';
}

    // Relationship: user has many borrows
    public function borrows()
    {
        return $this->hasMany(Borrow::class);
    }
}
