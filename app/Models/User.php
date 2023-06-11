<?php

namespace App\Models;

use Illuminate\Auth\Authenticatable;
use Illuminate\Auth\Passwords\CanResetPassword;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Foundation\Auth\Access\Authorizable;

/**
 * @property string $email
 * @property string $password
 */
class User extends Model
{
    use HasApiTokens;
    use Notifiable;
    use Authenticatable;
    use Authorizable;
    use Authenticatable;
    use Authorizable;
    use CanResetPassword;

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];
}
