<?php

declare(strict_types = 1);

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;

/**
 * @property int $id
 * @property string $name
 *
 * @method filterByKeyWord(array $filters)
 */
class Country extends Model
{
    public    $timestamps = false;
    protected $table      = 'countries';
    protected $fillable   = [
        'name',
    ];

    public function getId(): int
    {
        return $this->id;
    }

    public function getName(): string
    {
        return $this->name;
    }


    public function scopeFilterByKeyword(Builder $builder, array $filters): Builder
    {
        return $builder->when(!empty($filters['keyword']), static function (Builder $query) use ($filters) {
            $keyword = $filters['keyword'];
            $query->where('name', 'like', '%' . $keyword . '%', 'or');
        });
    }
}
