<?php

namespace App\Models;

class UsersModel extends Model
{
    protected int $id;
    protected string $name;
    protected string $email;
    protected int $isAdmin;
    protected string $password;

    public function __construct()
    {
        $this->table = 'users';
    }

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @param int $id
     *
     * @return UsersModel
     */
    public function setId(int $id): UsersModel
    {
        $this->id = $id;

        return $this;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @param string $name
     *
     * @return UsersModel
     */
    public function setName(string $name): UsersModel
    {
        $this->name = $name;

        return $this;
    }

    /**
     * @return string
     */
    public function getEmail(): string
    {
        return $this->email;
    }

    /**
     * @param string $email
     *
     * @return UsersModel
     */
    public function setEmail(string $email): UsersModel
    {
        $this->email = $email;

        return $this;
    }

    /**
     * @return int
     */
    public function getIsAdmin(): int
    {
        return $this->isAdmin;
    }

    /**
     * @param int $isAdmin
     *
     * @return UsersModel
     */
    public function setIsAdmin(int $isAdmin): UsersModel
    {
        $this->isAdmin = $isAdmin;

        return $this;
    }

    /**
     * @return string
     */
    public function getPassword(): string
    {
        return $this->password;
    }

    /**
     * @param string $password
     *
     * @return UsersModel
     */
    public function setPassword(string $password): UsersModel
    {
        $this->password = $password;

        return $this;
    }
}
