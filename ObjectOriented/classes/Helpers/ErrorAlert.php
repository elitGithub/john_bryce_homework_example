<?php

namespace Elit1\ObjectOriented\Helpers;

class ErrorAlert
{


    public static function echo ($message)
    {
        echo '<div class="alert alert-danger" role="alert">' . $message . '</div>';
    }
}