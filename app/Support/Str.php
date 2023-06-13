<?php

declare(strict_types = 1);

namespace App\Support;

use Illuminate\Support\Str as BaseStr;

use function number_format;
use function preg_replace;
use function str_repeat;
use function str_replace;
use function strlen;
use function strtolower;
use function substr;
use function ucwords;

class Str extends BaseStr
{
    public static function addZeros(string $value, int $finalLength = 2, string $dir = 'left'): string
    {
        $length = self::length($value);
        if ($length >= $finalLength) {
            return $value;
        }
        $diff = $finalLength - $length;
        $value = $dir === 'left' ? str_repeat('0', $diff) . $value : $value . str_repeat('0', $diff);

        return $value;
    }

    public static function formatBalance(?int $amount = 0, int $d = 2): string
    {
        //$amount = str_replace([',', ' '], ['.', ''], $amount);
        $amount = (float) $amount;
        $amount /= 100;
        $amount = number_format($amount, $d, '.', '');

        return $amount;
    }

    public static function formatCredits(?float $amount = 0): string
    {
        $amount = (string) ($amount + 0);

        return str_replace(',', '.', $amount);
    }

    public static function formatScore(?float $amount = 0, int $d = 2): string
    {
        $amount = number_format($amount, $d, '.', '');

        return $amount;
    }

    public static function sanitizeMobileNumber($number): ?int
    {
        if (empty($number)) {
            return null;
        }

        $number = preg_replace('#[^0-9]+#', '', $number);
        if (strlen($number) !== 9 || substr($number, 0, 1) !== 5) {
            return null;
        }

        return (int) $number;
    }

    public static function snakeCaseToCamelCase(string $string): string
    {
        $str = str_replace('_', '', ucwords($string, '_'));

        return $str;
    }

    public static function camelCaseToSnakeCase(string $string): string
    {
        $string = strtolower(preg_replace('/(?<!^)[A-Z]/', '_$0', $string));

        return $string;
    }

    public static function convertSpacesToDashes(string $string): string
    {
        $string = str_replace(' ', '-', $string);

        return $string;
    }
}
