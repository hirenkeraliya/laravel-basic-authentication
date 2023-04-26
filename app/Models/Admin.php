<?php

namespace App\Models;

use App\Mail\AdminResetPasswordMail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Support\Facades\Mail;

class Admin extends Authenticatable
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Send a password reset notification to the user.
     *
     * @param string $token
     */
    public function sendPasswordResetNotification($token)
    {
        Mail::to([[
            'name' => $this->name,
            'email' => $this->email,
        ]])->send(new AdminResetPasswordMail($this, $token));
    }
}
