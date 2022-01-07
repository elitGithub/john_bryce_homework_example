<?php

namespace Elit1\ObjectOriented\Helpers;

class CreateDirectory
{
    public static function createDir (string $newDirPath, $permissions = 0777)
    {
        if (!is_dir($newDirPath)) {
            mkdir($newDirPath, $permissions);
        }
    }

}