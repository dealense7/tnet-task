<?php

declare(strict_types = 1);

namespace App\DataTransferObjects;

use Illuminate\Support\Facades\Hash;

class UserDto extends DataTransferObject
{
    public static function toInternal(array $data): array
    {
        return [
            'name'     => self::getData($data, 'name'),
            'email'    => self::getData($data, 'email'),
            'password' => Hash::make(self::getData($data, 'password')),
        ];
    }
}
