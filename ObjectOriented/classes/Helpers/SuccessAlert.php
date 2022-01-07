<?php

namespace Elit1\ObjectOriented\Helpers;

class SuccessAlert
{

    public static function echo ($message)
    {
        echo '<div class="alert alert-success" role="alert">' . $message . '</div>';
    }

}