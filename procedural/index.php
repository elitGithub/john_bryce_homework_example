<?php

require_once 'header.php';
require_once 'functions.php';

// Create the connection object we're going to use throughout our app
$connection = connectToDb();

// This defines what can be requested from the server.
$routes = [
    'getusers',
    'adduser',
    'edituser',
    'deleteuser',
    'uploadFile',
];

// If we request nothing - we get the default.

if (empty($_GET['route'])) {
    echo '<h1>Choose an option</h1>';
}

// Check if the client can get what they are requesting (think a view)
if (!empty($_GET['route']) && in_array($_GET['route'], $routes, true)) {
    if (is_file($_GET['route'] . '.php')) {
        // Yes, you can request routes dynamically!
        require_once $_GET['route'] . '.php';
    } else {
        // If this was a real app, here we'd send a 404. But for this example we just kill the script.
        die('Unknown file requested.');
    }
}

require_once 'footer.php';