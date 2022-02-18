<?php

namespace App\Core;

use PDO;
use PDOException;

class Database extends PDO
{
    // Connexion informations
    private const DB_HOST = 'localhost';
    private const DB_USER = 'root';
    private const DB_PW = '';
    private const DB_NAME = 'leomoilledotcom';

    private static $instance;


    private function __construct()
    {
        $_dsn = 'mysql:dbname=' . self::DB_NAME . ';host=' . self::DB_HOST;

        try {
            parent::__construct($_dsn, self::DB_USER, self::DB_PW);

            $this->setAttribute(PDO::MYSQL_ATTR_INIT_COMMAND, 'SET NAMES utf8');
            $this->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_OBJ);
            $this->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            $this->exec('SET NAMES utf8');
        } catch (PDOException $e) {
            die($e->getMessage());
        }
    }

    /**
     * @return static
     */
    public static function getInstance(): self
    {
        if (self::$instance === null) {
            self::$instance = new self();
        }

        return self::$instance;
    }
}
