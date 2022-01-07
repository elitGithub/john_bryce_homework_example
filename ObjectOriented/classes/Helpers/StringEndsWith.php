<?php

namespace Elit1\ObjectOriented\Helpers;

use JetBrains\PhpStorm\Pure;

class StringEndsWith
{
    #[Pure] public static function check ($haystack, $needle, $case = true): bool
    {
        if (function_exists('str_ends_with') && $case) {
            return str_ends_with($haystack, $needle);
        }
        $expectedPosition = strlen($haystack) - strlen($needle);
        if ($case) {
            return static::endsWith($haystack, $needle);
        }
        return strripos($haystack, $needle, 0) === $expectedPosition;
    }

    private static function endsWith($haystack, $needle): bool
    {
        $length = strlen($needle);
        return !($length > 0) || substr($haystack, -$length) === $needle;
    }

}