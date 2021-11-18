<?php

namespace App\Models;

use App\Core\Database;

class Model extends Database
{
    protected string $table;
    private Database $db;

    public function find(int $id)
    {
        return $this->customQuery("SELECT * FROM $this->table WHERE id = $id")->fetch();
    }

    public function customQuery(string $sql, array $attr = null)
    {
        $this->db = Database::getInstance();

        if ($attr !== null) {
            $query = $this->db->prepare($sql);
            $query->execute($attr);

            return $query;
        } else {
            return $this->db->query($sql);
        }
    }

    public function findBy(array $args)
    {
        $fields = [];
        $values = [];

        foreach ($args as $field => $value) {
            $fields[] = "$field = ?";
            $values[] = $value;
        }

        $fields_list = implode(' AND ', $fields);

        return $this->customQuery("SELECT * FROM $this->table WHERE $fields_list", $values)->fetchAll();
    }

    public function findOneBy(array $args)
    {
        $fields = [];
        $values = [];

        foreach ($args as $field => $value) {
            $fields[] = "$field = ?";
            $values[] = $value;
        }

        $fields_list = implode(' AND ', $fields);

        return $this->customQuery("SELECT * FROM $this->table WHERE $fields_list", $values)->fetch();
    }

    public function findAll()
    {
        $query = $this->customQuery("SELECT * FROM $this->table");

        return $query->fetchAll();
    }

    public function findNum(int $num)
    {
        $query = $this->customQuery("SELECT * FROM $this->table LIMIT $num");

        return $query->fetchAll();
    }

    public function create()
    {
        $fields = [];
        $values = [];
        $countArgs = [];

        foreach ($this as $field => $value) {
            if ($value !== null && $field !== 'db' && $field !== 'table') {
                $fields[] = $field;
                $countArgs[] = '?';
                $values[] = $value;
            }
        }

        $fields_list = implode(', ', $fields);
        $countArgsList = implode(', ', $countArgs);

        return $this->customQuery("INSERT INTO $this->table ($fields_list) VALUES($countArgsList)", $values);
    }

    public function hydrate($data): Model
    {
        foreach ($data as $key => $value) {
            $setter = 'set' . ucfirst($key);

            if (method_exists($this, $setter)) {
                $this->$setter($value);
            }
        }

        return $this;
    }

    public function update()
    {
        $fields = [];
        $values = [];

        foreach ($this as $field => $value) {
            if ($value !== null && $field !== 'db' && $field !== 'table') {
                $fields[] = "$field = ?";
                $values[] = $value;
            }
        }
        $values[] = $this->id;
        $fields_list = implode(', ', $fields);

        return $this->customQuery("UPDATE $this->table SET $fields_list WHERE id = ?", $values);
    }

    public function delete(int $id)
    {
        return $this->customQuery("DELETE FROM $this->table WHERE id = ?", [$id]);
    }
}
