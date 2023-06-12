<?php

declare(strict_types = 1);

namespace App\Contracts\Models;

use Illuminate\Contracts\Auth\Access\Authorizable as AuthorizableContract;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Contracts\Auth\CanResetPassword as CanResetPasswordContract;

interface UserContract extends AuthenticatableContract, AuthorizableContract, CanResetPasswordContract
{
}
