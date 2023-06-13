<?php

declare(strict_types = 1);

namespace App\Enums;
enum PlayerPosition: int
{
    case GOALKEEPER = 1;
    case DEFENDER   = 2;
    case MIDFIELDER = 3;
    case ATTACKER   = 4;

    public function toText(): string
    {
        return match ($this) {
            self::GOALKEEPER => 'Goalkeeper',
            self::DEFENDER => 'Defender',
            self::MIDFIELDER => 'Midfielder',
            self::ATTACKER => 'Attacker',
        };
    }
}
