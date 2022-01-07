<?php

namespace Elit1\ObjectOriented\Helpers;

class DoesDirExistsValidator
{

    public static function dirExists (string $dirname)
    {
        return is_dir($dirname);
    }

}