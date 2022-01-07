<?php

namespace Elit1\ObjectOriented\Helpers;

class FlattenArray
{
    public static function flatten ($input, $output = null)
    {
        if ($input == null) {
            return null;
        }
        if ($output == null) {
            $output = [];
        }
        foreach ($input as $value) {
            if (is_array($value)) {
                $output = static::flatten($value, $output);
            } else {
                $output[] = $value;
            }
        }
        return $output;
    }
}