<?php

namespace App\Model;

use Exception;

require_once('model/Manager.php');

class AccountManager extends Manager
{
    public function signup($name, $email, $password)
    {
        $encryptPass = password_hash($password, PASSWORD_DEFAULT);
        
        $db  = $this->dbConnect();
        $req = $db->prepare(
            'INSERT INTO users(name, email, is_admin, password)
                                            VALUES (:name, :email, 0, :password)'
        );
        $req->execute([
            ':name'     => $name,
            ':email'    => $email,
            ':password' => $encryptPass,
        ]);
    }
    
    /**
     * @throws Exception
     */
    public function login(string $email, string $password)
    {
        $db  = $this->dbConnect();
        $req = $db->prepare('SELECT * FROM users WHERE email = ?');
        $req->execute(array($email));
        
        $user = $req->fetch();
        
        $checkPass = password_verify($password, $user['password']);
        
        if ($checkPass) {
            $_SESSION['name']     = $user['name'];
            $_SESSION['email']    = $user['email'];
            $_SESSION['is_admin'] = $user['is_admin'];
        } else {
            throw new Exception('Vérifiez votre saisie');
        }
    }
    
    public function logout()
    {
        $_SESSION = [];
    }
}
