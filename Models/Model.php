<?php

namespace App\Models;

use App\Core\Database;
use PDO;
use PDOStatement;

class Model extends Database
{
    protected string $table;
    private Database $db;

    /**
     * @param int $id
     *
     * @return mixed
     */
    public function find(int $id)
    {
        $req = $this->customQuery(
            "SELECT * FROM $this->table WHERE id = ?",
            [$id]
        );
        $req->setFetchMode(PDO::FETCH_CLASS, static::class);

        return $req->fetch();
    }

    /**
     * @param string $sql
     * @param array|null $attr
     *
     * @return false|PDOStatement
     */
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

    /**
     * @param array $args
     *
     * @return array|false
     */
    public function findBy(array $args)
    {
        $fields = [];
        $values = [];

        foreach ($args as $field => $value) {
            $fields[] = "$field = ?";
            $values[] = $value;
        }

        $fields_list = implode(' AND ', $fields);

        return $this->customQuery(
            "SELECT * FROM $this->table WHERE $fields_list",
            $values
        )->fetchAll();
    }

    /**
     * @param array $args
     *
     * @return mixed
     */
    public function findOneBy(array $args)
    {
        $fields = [];
        $values = [];

        foreach ($args as $field => $value) {
            $fields[] = "$field = ?";
            $values[] = $value;
        }

        $fields_list = implode(' AND ', $fields);

        return $this->customQuery(
            "SELECT * FROM $this->table WHERE $fields_list",
            $values
        )->fetch();
    }

    /**
     * @return array|false
     */
    public function findAll()
    {
        $query = $this->customQuery("SELECT * FROM $this->table");

        return $query->fetchAll();
    }

    /**
     * @param int $limit
     *
     * @return array|false
     */
    public function findLimit(int $limit)
    {
        $query = $this->customQuery("SELECT * FROM $this->table LIMIT $limit");

        return $query->fetchAll();
    }

    /**
     * @return false|PDOStatement
     */
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

        return $this->customQuery(
            "INSERT INTO $this->table ($fields_list) VALUES($countArgsList)",
            $values
        );
    }

    /**
     * @param $data
     *
     * @return $this
     */
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

    /**
     * @return false|PDOStatement
     */
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

        return $this->customQuery(
            "UPDATE $this->table SET $fields_list WHERE id = ?",
            $values
        );
    }

    /**
     * @param int $id
     *
     * @return false|PDOStatement
     */
    public function delete(int $id)
    {
        return $this->customQuery("DELETE FROM $this->table WHERE id = ?", [$id]);
    }
}
