<?php

declare(strict_types = 1);

namespace App\DataTransferObjects;

use App\Models\Model;

abstract class DataTransferObject
{
    public abstract static function toInternal(array $data): array;

    public static function getData(Model|array $data, string $needle, mixed $default = null): mixed
    {
        return data_get($data, $needle, $default);
    }
}
