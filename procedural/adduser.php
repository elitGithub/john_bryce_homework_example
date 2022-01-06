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
?>

<div class="container-fluid">
    <form method="post">
        <div class="form-group">
            <label for="email">Email address</label>
            <input type="email" class="form-control" name="email" value="<?php
            echo $_POST['email'] ?? '' ?>" id="email" aria-describedby="emailHelp" placeholder="Enter email">
            <small id="emailHelp" class="form-text text-muted">We'll never share your email with anyone else.</small>
            <?php
            echo $errors['email'] ?? '' ?>
        </div>
        <div class="form-group">
            <label for="name">Name</label>
            <input class="form-control" name="name" id="name" value="<?php
            echo $_POST['name'] ?? '' ?>" aria-describedby="name" placeholder="Enter your name">
            <?php
            echo $errors['name'] ?? '' ?>
        </div>
        <div class="form-group">
            <label for="age">Age</label>
            <input class="form-control" name="age" value="<?php
            echo $_POST['age'] ?? '' ?>" id="age" aria-describedby="age" placeholder="Enter your age">
            <?php
            echo $errors['age'] ?? '' ?>
        </div>
        <div class="form-group">
            <input name="submit" value="Submit" type="submit" class="btn btn-primary mt-3 mb-2">
        </div>
    </form>
</div>

