<?php

namespace App\Model;

require_once('model/Manager.php');

class AccountManager extends Manager
{
    public function signup($name, $email, $password)
    {
        $encryptPass = password_hash($password, PASSWORD_DEFAULT);
        
        $db  = $this->dbConnect();
        $req = $db->prepare(
            'INSERT INTO users(name, email, is_admin, password)
                                            VALUES (:name, :email, 1, :password)'
        );
        $req->execute([
            ':name'     => $name,
            ':email'    => $email,
            ':password' => $encryptPass,
        ]);
    }
}
