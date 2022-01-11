<?php

namespace Elit1\ObjectOriented\Models;

use Elit1\ObjectOriented\Database;
use Elit1\ObjectOriented\UploadsDir;

class ImageModel implements TableModel
{
    private Database $db;

    public function __construct ()
    {
        $this->db = new Database();
    }

    public function findAll (): array
    {
        return $this->db->getRecords('SELECT * FROM images', []);
    }

    public static function TableBody ($row)
    {
        $src = UploadsDir::uploadPath() . DIRECTORY_SEPARATOR . $row['filename'];
        echo "<tr>
      <th scope='row'>{$row['id']}</th>
      <td>{$row['filename']}</td>
      <td><img style='width: 150px;' src=$src alt='image' class='img img-thumbnail'></td>
                </tr>";
    }
}