<?php

namespace Elit1\ObjectOriented\Helpers;

class HashName
{
    public static function generateFileNameHash (string $filePath = ""): string
    {
        if (is_null($filePath) || trim($filePath) == "") {
            return $filePath;
        }
        $fileInfo = pathinfo($filePath);
        return md5(CreateHash::hash() . $fileInfo['filename']) . "_" . time() . "." . $fileInfo['extension'];
    }

}