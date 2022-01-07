<?php

namespace Elit1\ObjectOriented\Helpers;

class StringStartsWith
{
    public static function stringStartsWith ($haystack, $needle, $case = true)
    {
        if (function_exists('str_starts_with')) {
            return str_starts_with($haystack, $needle);
        }

        if ($case) {
            return strpos($haystack, $needle, 0) === 0;
        }
        return stripos($haystack, $needle, 0) === 0;
    }

}