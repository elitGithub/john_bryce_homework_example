<?php

namespace Elit1\ObjectOriented\Helpers;

use RuntimeException;

class FilesErrorsValidator
{

    public static function validate ()
    {
        // Undefined | Multiple Files | $_FILES Corruption Attack
        // If this request falls under any of them, treat it invalid.
        if (!isset($_FILES['upfile']['error']) || is_array($_FILES['upfile']['error'])) {
            throw new RuntimeException('Invalid parameters.');
        }

        switch ($_FILES['upfile']['error']) {
            case UPLOAD_ERR_OK:
                break;
            case UPLOAD_ERR_NO_FILE:
                throw new RuntimeException('No file sent.');
            case UPLOAD_ERR_INI_SIZE:
            case UPLOAD_ERR_FORM_SIZE:
                throw new RuntimeException('Exceeded filesize limit.');
            default:
                throw new RuntimeException('Unknown errors.');
        }
    }

}