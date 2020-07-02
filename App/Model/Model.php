<?php


namespace App\Model;


use App\Core\Database;

class Model
{
    protected $dbConnection;
    protected $table = '';
    protected $primary = 'id';
    protected $fieldsList = [];

    public function __construct()
    {
        $this->dbConnection = Database::connect();
    }

    public function getAll()
    {
        $sql = "SELECT * FROM {$this->table}";

        $response = [];

        $result = $this->dbConnection->query($sql);

        if ($result)
        {
            while ($row = \mysqli_fetch_assoc($result))
            {
                $response[] = $row;
            }
        }

        return $response;
    }

    public function getByPrimary($id)
    {
        $sql = "SELECT * FROM {$this->table} WHERE {$this->primary}='{$id}'";

        $response = [];

        $result = $this->dbConnection->query($sql);

        if ($result)
        {
            $row = \mysqli_fetch_assoc($result);
            $response = $row;
        }

        return $response;
    }

    public function create()
    {
        $values = [];
        foreach ($this->fieldsList as $field)
        {
            $values[] = htmlspecialchars($_POST[$field]);
        }

        $valuesString = implode("', '", $values);
        $fieldsString = implode(", ", $this->fieldsList);

        $sql = "INSERT INTO {$this->table} ({$fieldsString}) VALUES ('{$valuesString}')";

        $this->dbConnection->query($sql);
    }

    public function update($id)
    {
        $values = [];
        foreach ($this->fieldsList as $field)
        {
            $values[$field] = $_POST[$field];
        }

        array_walk($values, function (&$value, $key) {
            $value = htmlspecialchars($value);
            $value = "{$key}='{$value}'";
        });

        $valueString = implode(', ', $values);

        $sql = "UPDATE {$this->table} SET {$valueString} WHERE {$this->primary}='{$id}'";

        $this->dbConnection->query($sql);
    }
}