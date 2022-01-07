<?php

use Elit1\ObjectOriented\Helpers\ErrorAlert;

$user = new Elit1\ObjectOriented\Users();

$user->id = $_GET['delete'];

if ($user->delete()) {
    Elit1\ObjectOriented\Helpers\Navigator::redirect('index.php?route=getusers');
}

ErrorAlert::echo('User NOT deleted.');