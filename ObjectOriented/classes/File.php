<?php

namespace Elit1\ObjectOriented;

class File
{

    private Database $db;

    public function __construct (public string $fileName) {
        $this->db = Database::getInstance();
    }

    public function addFileRecordToDb (): bool
    {
        $sql = 'INSERT INTO images (filename) VALUES (?);';
        $this->db->pquery($sql, [$this->fileName]);
        return $this->db->hasAffectedRows();
    }

}