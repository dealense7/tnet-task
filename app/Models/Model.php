<?php

declare(strict_types = 1);

namespace App\Models;


use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model as BaseModel;

/**
 * @mixin \Illuminate\Database\Eloquent\Builder
 */
class Model extends BaseModel
{
    use HasFactory;
}
