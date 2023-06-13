<?php

declare(strict_types = 1);

namespace App\Models;

use App\Enums\PlayerPosition;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * @property int $id
 * @property int $country_id
 * @property int $team_id
 * @property string $first_name
 * @property string $last_name
 * @property int $age
 * @property int $type
 * @property int $market_value
 * @property \App\Models\Country $country
 * @property \App\Models\Team $team
 */
class Player extends Model
{
    protected $table    = 'players';
    protected $fillable = [
        'name',
        'country_id',
        'first_name',
        'last_name',
        'age',
        'type',
        'market_value',
    ];

    public function getId(): int
    {
        return $this->id;
    }

    public function getCountryId(): int
    {
        return $this->country_id;
    }

    public function getTeamId(): int
    {
        return $this->team_id;
    }

    public function getFirstName(): string
    {
        return $this->first_name;
    }

    public function getLastName(): string
    {
        return $this->last_name;
    }

    public function getAge(): int
    {
        return $this->age;
    }

    public function getType(): int
    {
        return $this->type;
    }

    public function getTypeToText(): string
    {
        return PlayerPosition::from($this->getType())->toText();
    }

    public function getMarketValue(): int
    {
        return $this->market_value;
    }

    public function team(): BelongsTo
    {
        return $this->belongsTo(Team::class, 'team_id');
    }

    public function country(): BelongsTo
    {
        return $this->belongsTo(Country::class, 'country_id');
    }
}
