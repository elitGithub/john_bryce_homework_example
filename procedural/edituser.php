<?php

if (empty($_GET['id'])) {
    header('Location:index.php');
}


if (isset($_POST['submit'])) {
    $errors = validateInputHasKeys($_POST, ['name', 'email', 'age']);
    if (empty($errors)) {
        $userExists = checkIsUnique($_POST['email'], $connection);
        if ($userExists) {
            errorAlert('User with this email already exists');
            return;
        }
        $result = saveUser($_POST, $connection, $_GET['id']);
        if ($result) {
            // This is a convenient way to naturally send the user back to the main page.
            echo '<div class="alert alert-success" role="alert">User saved successfully!</div>';
            echo '<script>setTimeout(() => window.location = "index.php?route=getusers", 1000)</script>';
        }
    }
}

$userData = getUserById($_GET['id'], $connection);

require_once 'userEditForm.php';