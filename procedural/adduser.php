<?php

if (isset($_POST['submit'])) {
    $errors = validateInputHasKeys($_POST, ['name', 'email', 'age']);
    if (empty($errors)) {
        $userExists = checkIsUnique($_POST['email'], $connection);
        if ($userExists) {
            errorAlert('User with this email already exists');
            return;
        }
        $result = addNewUser($_POST, $connection);
        if ($result) {
            // This is a convenient way to naturally send the user back to the main page.
            successAlert('User added successfully!');
            echo '<script>setTimeout(() => window.location = "index.php?route=getusers", 1000)</script>';
        }
    }
}

$userData = $_POST;

require_once 'userEditForm.php';
