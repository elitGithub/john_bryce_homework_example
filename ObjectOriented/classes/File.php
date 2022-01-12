<?php

namespace Elit1\ObjectOriented;

class File
{

    private Database $db;

    public function __construct (public string $fileName) {
        $this->db = Database::getInstance();
    }

    public function addFileRecordToDb (): int
    {
        $sql = 'INSERT INTO images (filename) VALUES (?);';
        $this->db->pquery($sql, [$this->fileName]);
        $this->db->lastInsertId('images', 'id');
        return $this->db->getLastInsertId();
    }

    public function linkImageToUser($id, $userId): bool
    {
        $sql = 'INSERT INTO image2user (user_id, image_id) VALUES (?, ?)';
        $this->db->pquery($sql, [$userId, $id]);
        return $this->db->hasAffectedRows();
    }

}