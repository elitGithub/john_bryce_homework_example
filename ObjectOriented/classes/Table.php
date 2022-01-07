<?php

namespace Elit1\ObjectOriented;

class Table
{

    private array $tableData;
    private array $tableHeader;

    public function __construct (array $tableData, array $tableHeader)
    {
        $this->tableData = $tableData;
        $this->tableHeader = $tableHeader;
    }

    public function startTable (): static
    {
        echo '<table class="table table-striped table-dark"><tbody>';
        return $this;
    }

    public function headersRow (): static
    {
        echo '<thead ><tr>';
        foreach ($this->tableHeader as $tableHead) {
            echo '<th scope="col">' . $tableHead . '</th>';
        }
        echo '</tr></thead>';
        return $this;
    }

    public function tableBody (): static
    {
        if (empty($this->tableData)) {
            echo '</tbody></table>';
            echo 'No results found.';
            return $this;
        }

        foreach ($this->tableData as $row) {
            echo "<tr>
      <th scope='row'>{$row['id']}</th>
      <td>{$row['name']}</td>
      <td>{$row['age']}</td>
      <td>{$row['email']}</td>
      <td><a href='index.php?route=edituser&id={$row['id']}'><button class='btn btn-primary'>Edit</button></a></td>
      <td><a href='deleteUser.php?delete={$row['id']}'><button class='btn btn-danger'>Delete</button></a></td>
                </tr>";
        }
        return $this;
    }
}