<?php

namespace Elit1\ObjectOriented;

class UploadsDir
{
    public static function uploadPath(): bool | array | string
    {
        return getenv('UPLOADS_DIR');
    }

}