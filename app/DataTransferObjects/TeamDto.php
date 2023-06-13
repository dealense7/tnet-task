<?php

declare(strict_types = 1);

namespace App\DataTransferObjects;

class TeamDto extends DataTransferObject
{
    public static function toInternal(array $data): array
    {
        return [
            'name' => self::getData($data, 'name'),
        ];
    }
}
