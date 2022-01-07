<?php

namespace Elit1\ObjectOriented\Helpers;

class ChangeKeyCase
{
    public static function change ($arr)
    {
        return is_array($arr) ? array_change_key_case($arr) : $arr;
    }

}