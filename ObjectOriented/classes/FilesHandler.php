<?php

namespace Elit1\ObjectOriented;

use Elit1\ObjectOriented\Helpers\CompareIntSizes;
use Elit1\ObjectOriented\Helpers\CreateHash;
use Elit1\ObjectOriented\Helpers\FilesErrorsValidator;
use Elit1\ObjectOriented\Helpers\HashName;
use finfo;
use RuntimeException;

class FilesHandler
{

    public string $uploadsDir;
    public function __construct (private int $uploadMaxSize = 10000000) {}

    public function fileValidation (): bool | int | string
    {
        FilesErrorsValidator::validate();

        // You should also check filesize here.
        if (CompareIntSizes::greaterThan($_FILES['upfile']['size'], $this->uploadMaxSize)) {
            throw new RuntimeException('Exceeded filesize limit.');
        }

        // DO NOT TRUST $_FILES['upfile']['mime'] VALUE !!
        // Check MIME Type by yourself.
        $finfo = new finfo(FILEINFO_MIME_TYPE);
        if (!in_array(
            $finfo->file($_FILES['upfile']['tmp_name']),
            [
                'jpg' => 'image/jpeg',
                'png' => 'image/png',
                'gif' => 'image/gif',
            ],
            true
        )) {
            throw new RuntimeException('Invalid file format.');
        }

        $fileInfo = pathinfo($_FILES['upfile']['name']);

        return $fileInfo['filename'] . '.' . $fileInfo['extension'];
    }

    public function uploadFile ($ext): string
    {
        // You should name it uniquely.
        // DO NOT USE $_FILES['upfile']['name'] WITHOUT ANY VALIDATION !!
        // On this example, obtain safe unique name from its binary data.
        $fileName = HashName::generateFileNameHash($ext);
        if (!move_uploaded_file(
            $_FILES['upfile']['tmp_name'],
            $this->uploadsDir . DIRECTORY_SEPARATOR . $fileName
        )) {
            throw new RuntimeException('Failed to move uploaded file.');
        }

        return $fileName;
    }

    /**
     * @param  string  $uploadsDir
     *
     * @return FilesHandler
     */
    public function setUploadsDir (string $uploadsDir): FilesHandler
    {
        $this->uploadsDir = $uploadsDir;
        return $this;
    }


}