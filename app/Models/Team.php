<?php

declare(strict_types = 1);

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * @property int $id
 * @property int $country_id
 * @property int $user_id
 * @property int $balance
 * @property string $name
 * @property \App\Models\User $owner
 * @property \App\Models\Country $country
 * @property \Illuminate\Support\Collection $players
 */
class Team extends Model
{
    protected $table    = 'teams';
    protected $fillable = [
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

    public function getBalance(): int
    {
        return $this->balance;
    }

    public function getFormattedBalance(): string
    {
        return number_format($this->getBalance()/100, 2);
    }

    public function owner(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function country(): BelongsTo
    {
        return $this->belongsTo(Country::class, 'country_id');
    }

    public function players(): HasMany
    {
        return $this->hasMany(
            Player::class,
            'team_id',
        );
    }
}
