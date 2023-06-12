<?php

declare(strict_types = 1);

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * @property int $id
 * @property int $country_id
 * @property int $user_id
 * @property string $name
 */
class Team extends Model
{
    protected $table      = 'teams';
    protected $fillable   = [
        'name',
        'country_id',
        'user_id',
    ];

    public function getId(): int
    {
        return $this->id;
    }

    public function getCountryId(): int
    {
        return $this->country_id;
    }

    public function getUserId(): int
    {
        return $this->user_id;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function owner(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function country(): BelongsTo
    {
        return $this->belongsTo(Country::class, 'country_id');
    }
}
