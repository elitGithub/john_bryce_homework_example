<?php

$images = getAllImages($connection);

echo '<table class="table table-striped table-dark"><tbody>';
printTableHead(['ID', 'FileName', 'Thumb']);
if (sizeof($images) < 1) {
    echo '</tbody></table>';
    echo 'No results found.';
    return;
}

foreach ($images as $image) {
    // APP ROOT is the source from which we consider the root of the application. Here it is just a slash, but it could be something like '/src/public/', or the like.
    $src = uploadPath() . DIRECTORY_SEPARATOR . $image['filename'];
    echo "<tr>
      <th scope='row'>{$image['id']}</th>
      <td>{$image['filename']}</td>
      <td><img style='width: 150px;' src=$src alt='image' class='img img-thumbnail'></td>
    </tr>";
}
echo '</tbody></table>';