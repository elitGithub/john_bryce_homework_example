<?php

require_once 'env.php';

/**
 * @return mysqli|void
 * Create a mysqli object, that will be used to execute queries.
 */
function connectToDb ()
{
    try {
        return new mysqli(getenv('DB_HOST'), getenv('DB_USER'), getenv('DB_PASSWORD'), getenv('DB_NAME'), getenv('DB_PORT'));
    } catch (Throwable $e) {
        echo 'error! error!';
        die($e->getMessage());
    }
}

/**
 * @param  array  $tableHeads
 *
 * @return void
 * Print an HTML table head.
 */
function printTableHead (array $tableHeads = [])
{
    echo '<thead ><tr>';
    foreach ($tableHeads as $tableHead) {
        echo '<th scope="col">' . $tableHead . '</th>';
    }
    echo '</tr></thead>';
}

/**
 * @param  array  $input
 * @param  array  $keys
 *
 * @return array
 * This is basic validitation of just having the input. Please bear in mind that this isn't complete and should be expanded on in a real app.
 */
function validateInputHasKeys (array $input, array $keys): array
{
    foreach ($keys as $key) {
        if (empty($input[$key])) {
            $errors[$key] = '<div class="alert alert-danger mt-1" role="alert">
                      ' . ucfirst($key) . ' is missing and cannot be empty.
                  </div>';
        }
    }

    return $errors ?? [];
}

/**
 * @param  array  $userData
 * @param  mysqli  $conn
 *
 * @return bool
 * In a real app, you don't return the error to the user. In this example, we want to see how we broke it.
 * Also note we are missing validation - we don't know if the passed data exists.
 */
function addNewUser (array $userData, mysqli $conn): bool
{
    $name = $conn->real_escape_string($userData['name']);
    $age = $conn->real_escape_string($userData['age']);
    $email = $conn->real_escape_string($userData['email']);
    $sql = "INSERT INTO `users` (`name`, `age`, `email`) VALUES ('$name', '$age', '$email')";

    $result = $conn->query($sql);
    if (!$result) {
        echo 'Error: ' . $conn->error;
        return false;
    }
    return true;
}