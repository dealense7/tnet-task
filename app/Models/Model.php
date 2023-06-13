<?php

declare(strict_types = 1);

namespace App\Models;


use App\Models\Traits\Paginatable;
use App\Models\Traits\Sortable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model as BaseModel;

/**
 * @mixin \Illuminate\Database\Eloquent\Builder
 */
class Model extends BaseModel
{
    use HasFactory;
    use Sortable;
    use Paginatable;

    protected int $maxPerPage = 100;
}
