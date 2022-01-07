<?php

namespace Elit1\ObjectOriented\Helpers;

class Navigator
{

    public static function redirect ($location)
    {
        header("Location:$location");
    }

    public static function redirectJs ($location)
    {
        echo "<script>setTimeout(() => window.location = '$location', 1000)</script>";
    }

}