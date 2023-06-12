<?php

declare(strict_types = 1);

namespace App\Models;

/**
 * @property int $id
 * @property string $name
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
}
