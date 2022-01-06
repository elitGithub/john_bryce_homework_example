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

function printTableHead (array $tableHeads = [])
{
    echo '<thead ><tr>';
    foreach ($tableHeads as $tableHead) {
        echo '<th scope="col">' . $tableHead . '</th>';
    }
    echo '</tr></thead>';
}

function validateInputHasKeys(array $input, array $keys): array
{
    foreach ($keys as $key) {
        if (empty($input[$key])) {
            $errors[$key] = '<div class="alert alert-danger mt-1" role="alert">
                      '.ucfirst($key).' is missing and cannot be empty.
                  </div>';
        }
    }

    return $errors ?? [];
}

function addNewUser(array $userData) {}