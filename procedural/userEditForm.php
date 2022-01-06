<div class="container-fluid">
    <form method="post">
        <div class="form-group">
            <label for="email">Email address</label>
            <input type="email" class="form-control" name="email" value="<?php
            echo $userData['email'] ?? '' ?>" id="email" aria-describedby="emailHelp" placeholder="Enter email">
            <small id="emailHelp" class="form-text text-muted">We'll never share your email with anyone else.</small>
            <?php
            echo $errors['email'] ?? '' ?>
        </div>
        <div class="form-group">
            <label for="name">Name</label>
            <input class="form-control" name="name" id="name" value="<?php
            echo $userData['name'] ?? '' ?>" aria-describedby="name" placeholder="Enter your name">
            <?php
            echo $errors['name'] ?? '' ?>
        </div>
        <div class="form-group">
            <label for="age">Age</label>
            <input class="form-control" name="age" value="<?php
            echo $userData['age'] ?? '' ?>" id="age" aria-describedby="age" placeholder="Enter your age">
            <?php
            echo $errors['age'] ?? '' ?>
        </div>
        <div class="form-group">
            <input name="submit" value="Submit" type="submit" class="btn btn-primary mt-3 mb-2">
        </div>
    </form>
</div>
