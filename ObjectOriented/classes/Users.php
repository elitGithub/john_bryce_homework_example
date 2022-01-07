<?php

namespace Elit1\ObjectOriented;

use Exception;

class Users extends Model
{
    private string $table = 'users';
    private string $idField = 'id';
    private Database $db;
    public string $email = '';
    public string $name = '';
    public int $age = 0;
    public int $id = 0;

    public function __construct ()
    {
        $this->db = new Database();
    }

    public function getAllUsers (): array
    {
        return $this->db->getRecords("SELECT * FROM $this->table", []);
    }

    public function getUserById ($id): array
    {
        return $this->db->getRecords("SELECT * FROM $this->table WHERE $this->idField = ?", [$id])[0] ?? [];
    }

    public static function tableName (): string
    {
        return 'users';
    }

    public function rules (): array
    {
        return [
            'name'  => [static::RULE_REQUIRED],
            'age'   => [
                static::RULE_REQUIRED,
                [static::RULE_MIN_VALUE, static::RULE_MIN_VALUE => 18],
                [static::RULE_MAX_VALUE, static::RULE_MAX_VALUE => 130],
            ],
            'email' => [
                static::RULE_REQUIRED,
                static::RULE_EMAIL,
                [static::RULE_UNIQUE, 'class' => static::class],
            ],

        ];
    }

    public function labels (): array
    {
        return [
            'email' => 'Email',
            'name'  => 'Your Name',
            'age'   => 'Age',
        ];
    }

    public function create (): bool
    {
        $sql = "INSERT INTO $this->table (email, age, name) VALUES (?, ?, ?);";
        $this->db->pquery($sql, [$this->email, $this->age, $this->name]);
        return $this->db->hasAffectedRows();
    }

    public function retrieveEntityInfo () {
        $user = $this->getUserById($this->id);
        if (!$user) {
            throw new Exception('User not found by id.');
        }
        $this->name = $user['name'];
        $this->age = $user['age'];
        $this->email = $user['email'];

    }


}