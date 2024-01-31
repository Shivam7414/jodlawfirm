<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Laravel\Scout\Searchable;
use App\Models\Application;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable, Searchable;

    protected $fillable = [
        'full_name',
        'phone_no',
        'email',
        'password',
        'address',
        'city',
        'country',
        'postal',
        'email_verified_at',
        'phone_verified_at'
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
        'phone_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

    public function applications()
    {
        return $this->hasMany(Application::class, 'user_id', 'id');
    }

    public function toSearchableArray()
    {
        return [
            'id' => $this->id,
            'full_name' => $this->firstname . ' ' . $this->lastname,
            'email' => $this->email,
        ];
    }
}
