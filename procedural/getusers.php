<?php

$result = $connection->query('SELECT * FROM users');

if ($result) {
    echo '<table class="table table-striped table-dark"><tbody>';
    printTableHead(['ID', 'Name', 'Age', 'Email', 'Edit', 'Delete']);
    if ($result->num_rows < 1) {
        echo '</tbody></table>';
        echo 'No results found.';
        return;
    }
    while ($row = $result->fetch_assoc()) {
        echo "<tr>
      <th scope='row'>{$row['id']}</th>
      <td>{$row['name']}</td>
      <td>{$row['age']}</td>
      <td>{$row['email']}</td>
      <td><button class='btn btn-primary'>Edit</button></td>
      <td><a href='deleteUser.php?delete={$row['id']}'><button class='btn btn-danger'>Delete</button></a></td>
    </tr>";
    }
    echo '</tbody></table>';
}