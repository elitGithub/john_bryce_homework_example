<?php

namespace Elit1\ObjectOriented\Helpers;

use Exception;

class CreateHash
{
    public static function hash (): string
    {
        if (php_sapi_name() === 'cli' || PHP_SAPI === 'cli') {
            $fakeIP = [];
            for ($i = 0; $i < 5; $i++) {
                try {
                    $fakeIP[] = random_int(0, 255);
                } catch (Exception $e) {
                    $fakeIP[] = 1;
                }
            }
            $_SERVER['REMOTE_ADDR'] = join('.', $fakeIP);
            try {
                $_SERVER['REMOTE_PORT'] = random_int(1, 65555);
            } catch (Exception $e) {
                $_SERVER['REMOTE_PORT'] = 1119;
            }
        }

        return sprintf("%08x", abs(crc32($_SERVER['REMOTE_ADDR'] . $_SERVER['REQUEST_TIME'] . $_SERVER['REMOTE_PORT'] . microtime())));
    }

}
