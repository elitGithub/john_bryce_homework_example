<?php

$users = getAllUsers($connection);

echo '<table class="table table-striped table-dark"><tbody>';
printTableHead(['ID', 'Name', 'Age', 'Email', 'Edit', 'Delete']);
if (sizeof($users) < 1) {
    echo '</tbody></table>';
    echo 'No results found.';
    return;
}

foreach ($users as $user) {
    echo "<tr>
      <th scope='row'>{$user['id']}</th>
      <td>{$user['name']}</td>
      <td>{$user['age']}</td>
      <td>{$user['email']}</td>
      <td><a href='index.php?route=edituser&id={$user['id']}'><button class='btn btn-primary'>Edit</button></a></td>
      <td><a href='deleteUser.php?delete={$user['id']}'><button class='btn btn-danger'>Delete</button></a></td>
    </tr>";
}
echo '</tbody></table>';