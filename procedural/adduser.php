<?php

if (isset($_POST['submit'])) {
    $errors = validateInputHasKeys($_POST, ['name', 'email', 'age']);
    if (empty($errors)) {
        $result = addNewUser($_POST, $connection);
        if ($result) {
            // This is a convenient way to naturally send the user back to the main page.
            echo '<div class="alert alert-success" role="alert">User added successfully!</div>';
            echo '<script>setTimeout(() => window.location = "index.php?route=getusers", 1000)</script>';
        }
    }
}

$userData = $_POST;

require_once 'userEditForm.php';
