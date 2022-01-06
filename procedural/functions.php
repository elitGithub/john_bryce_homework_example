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

function getAllUsers (mysqli $conn)
{
    $result = $conn->query('SELECT * FROM users');
    if (!$result) {
        return [];
    }

    return $result->fetch_all(MYSQLI_ASSOC);
}

function getUserById ($id, mysqli $conn)
{
    $sql = 'SELECT * FROM users WHERE id = ' . $conn->real_escape_string($id);
    $result = $conn->query($sql);
    if (!$result) {
        echo 'Error: ' . $conn->error;
        return [];
    }
    return $result->fetch_assoc();
}

function saveUser (array $userData, mysqli $conn, $id)
{
    $name = $conn->real_escape_string($userData['name']);
    $age = $conn->real_escape_string($userData['age']);
    $email = $conn->real_escape_string($userData['email']);
    $id = $conn->real_escape_string($id);
    $sql = "UPDATE users SET name = '$name', age = '$age', email = '$email' WHERE id = '$id'";
    return $conn->query($sql);
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

/**
 * @return void
 */
function makeSureWeHaveUploadsDir ()
{
    if (!is_dir('./uploads')) {
        mkdir('./uploads');
    }
}

/**
 * @return false|int|string
 */
function fileValidation ()
{
    // Undefined | Multiple Files | $_FILES Corruption Attack
    // If this request falls under any of them, treat it invalid.
    if (!isset($_FILES['upfile']['error']) || is_array($_FILES['upfile']['error'])) {
        throw new RuntimeException('Invalid parameters.');
    }

    // Check $_FILES['upfile']['error'] value.
    switch ($_FILES['upfile']['error']) {
        case UPLOAD_ERR_OK:
            break;
        case UPLOAD_ERR_NO_FILE:
            throw new RuntimeException('No file sent.');
        case UPLOAD_ERR_INI_SIZE:
        case UPLOAD_ERR_FORM_SIZE:
            throw new RuntimeException('Exceeded filesize limit.');
        default:
            throw new RuntimeException('Unknown errors.');
    }

    // You should also check filesize here.
    if ($_FILES['upfile']['size'] > 1000000) {
        throw new RuntimeException('Exceeded filesize limit.');
    }

    // DO NOT TRUST $_FILES['upfile']['mime'] VALUE !!
    // Check MIME Type by yourself.
    $finfo = new finfo(FILEINFO_MIME_TYPE);
    if (false === $ext = array_search(
            $finfo->file($_FILES['upfile']['tmp_name']),
            [
                'jpg' => 'image/jpeg',
                'png' => 'image/png',
                'gif' => 'image/gif',
            ],
            true
        )) {
        throw new RuntimeException('Invalid file format.');
    }

    return $ext;
}

/**
 * @param $ext
 *
 * @return string
 */
function uploadFile ($ext): string
{
    $fileName = sprintf(
        '%s.%s',
        sha1_file($_FILES['upfile']['tmp_name']),
        $ext
    );
    if (!move_uploaded_file(
        $_FILES['upfile']['tmp_name'],
        './uploads/'.$fileName
    )) {
        throw new RuntimeException('Failed to move uploaded file.');
    }

    echo 'File is uploaded successfully.';
    return $fileName;
}

function addNewFileToDb (string $fileName, mysqli $conn)
{
    $sql = "INSERT INTO images (filename) VALUES ('" . $conn->real_escape_string($fileName) . "')";
    $conn->query($sql);
}