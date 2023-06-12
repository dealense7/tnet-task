<?php

declare(strict_types = 1);

namespace App\Models;

/**
 * @property int $id
 * @property int $country_id
 * @property string $first_name
 * @property string $last_name
 * @property int $age
 * @property int $market_value
 */
class Player extends Model
{
    protected $table    = 'teams';
    protected $fillable = [
        'name',
        'country_id',
        'first_name',
        'last_name',
        'age',
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

    public function getMarketValue(): int
    {
        return $this->market_value;
    }
}
