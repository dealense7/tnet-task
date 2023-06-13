<?php

declare(strict_types = 1);

namespace App\Models;

use App\Contracts\AuthUserContract;
use App\Contracts\Models\UserContract;
use Illuminate\Auth\Authenticatable;
use Illuminate\Auth\Passwords\CanResetPassword;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Foundation\Auth\Access\Authorizable;

/**
 * @property int $id
 * @property string $name
 * @property string $email
 * @property string $password
 */
class User extends Model implements
    UserContract,
    AuthUserContract
{
    use HasApiTokens;
    use Notifiable;
    use Authenticatable;
    use Authorizable;
    use Authenticatable;
    use Authorizable;
    use CanResetPassword;

    protected $table    = 'users';
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
        'password'          => 'hashed',
    ];

    public function getId(): int
    {
        return $this->id;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getEmail(): string
    {
        return $this->email;
    }
}
