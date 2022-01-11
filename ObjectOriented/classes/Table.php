<?php

namespace Elit1\ObjectOriented;

use Elit1\ObjectOriented\Models\TableModel;

class Table
{

    private array $tableData;
    private array $tableHeader;
    private TableModel $model;

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
            $this->model::TableBody($row);
        }
        return $this;
    }

    /**
     * @param  TableModel  $model
     *
     * @return Table
     */
    public function setModel (TableModel $model): Table
    {
        $this->model = $model;
        return $this;
}
}