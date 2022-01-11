<?php

$users = new Elit1\ObjectOriented\Users();

$table = new Elit1\ObjectOriented\Table($users->getAllUsers(), ['ID', 'Name', 'Age', 'Email', 'Edit', 'Delete']);

$table->setModel($users)->startTable()->headersRow()->tableBody();