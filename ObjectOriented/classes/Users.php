<?php

namespace Elit1\ObjectOriented;

use Elit1\ObjectOriented\Models\TableModel;
use Exception;

class Users extends Model implements TableModel
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

    public static function optionsForSelect ()
    {
        $db = new Database();
        $result = $db->getRecords("SELECT * FROM users");
        echo "<option value='nothing'>Please Select A user</option>";
        if (!empty($result)) {
            foreach ($result as $data) {
                echo "<option value={$data['id']}>{$data['name']}</option>";
            }
        }
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

    public function delete (): bool
    {
        $sql = "DELETE FROM $this->table WHERE id = ?";
        $this->db->pquery($sql, [$this->id]);
        return $this->db->hasAffectedRows();
    }

    public static function usersTable ()
    {

    }


    public static function idField ()
    {
        return 'id';
    }

    public function update (): bool
    {
        $sql = "UPDATE $this->table SET email = ?, name = ?, age = ? WHERE id = ?";
        $this->db->pquery($sql, [$this->email, $this->name, $this->age, $this->id]);
        return $this->db->hasAffectedRows();
    }

    public static function TableBody ($row)
    {
        echo "<tr>
      <th scope='row'>{$row['id']}</th>
      <td>{$row['name']}</td>
      <td>{$row['age']}</td>
      <td>{$row['email']}</td>
      <td><a href='index.php?route=edituser&id={$row['id']}'><button class='btn btn-primary'>Edit</button></a></td>
      <td><a href='index.php?route=deleteuser&delete={$row['id']}'><button class='btn btn-danger'>Delete</button></a></td>
      <td><a href='index.php?route=showFiles&user_id={$row['id']}'><button class='btn btn-success'>Show Files</button></a></td>
                </tr>";
    }
}