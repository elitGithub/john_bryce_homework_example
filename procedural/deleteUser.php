<?php

// Safety: if we got nothing, no need to do any action. We just go back to the index.
if (empty($_GET['delete'])) {
    header('Location:index.php');
}

require_once 'functions.php';


// Create the connection object we're going to use throughout our app
$connection = connectToDb();

// Security: real_escape_string is the BASIC method to try and clear the input data.
// NEVER trust input passed via any type of input, including one that you are setting.
// Advanced methods include mysqli_bind_param and passing the input through your own validation before sending it to the DB.
$result = $connection->query('SELECT * FROM users WHERE id = ' . $connection->real_escape_string($_GET['delete']));

// If there is more or less than 1 row, our query or parameters where not correct. So, in this example, we just go back.
if ($result->num_rows !== 1) {
    header('Location:index.php');
}

// In a real app, here we'd flash a session message to the user, notifying them that their action was successful.
$delResult = $connection->query('DELETE FROM users WHERE id = ' . $connection->real_escape_string($_GET['delete']));

header('Location:index.php');