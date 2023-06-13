<?php

declare(strict_types = 1);

namespace App\Enums;
enum TransferTypes: int
{
    case OPEN  = 1;
    case CLOSE = 2;
    case SOLD  = 3;

    public function toText(): string
    {
        return match ($this) {
            self::OPEN => 'Open',
            self::CLOSE => 'Close',
            self::SOLD => 'Sold',
        };
    }
}
