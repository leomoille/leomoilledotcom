<?php

namespace App\Model;

use PDO;

class Manager
{
    protected function dbConnect(): PDO
    {
        return new PDO('mysql:host=localhost;dbname=leomoilledotcom;charset=utf8', 'root', '');
    }
}
