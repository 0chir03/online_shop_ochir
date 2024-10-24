<?php

namespace Model;

class User extends Model
{

    private int $id;
    private string $name;
    private string $email;
    private string $password;


    public static function create (string $name, string $email, string $password)
    {
        $stmt = self::getPDO()->prepare("INSERT INTO users (name, email, password) VALUES (:name, :email, :password)");
        $stmt->execute(['name' => $name, 'email' => $email, 'password' => $password]);
    }

    public static function getByLogin (string $login)
    {
        $stmt = self::getPDO()->prepare("SELECT * FROM users WHERE email = :login");
        $stmt->execute(['login' => $login]);
        $data = $stmt->fetch();
        if (empty($data)) {
            return null;
        }
        $obj = new self();
        $obj->id = $data['id'];
        $obj->name = $data['name'];
        $obj->email = $data['email'];
        $obj->password = $data['password'];

        return $obj;
    }

    public static function getById (string $userId)
    {
        $stmt = self::getPDO()->prepare("SELECT * FROM users WHERE id = :userId");
        $stmt->execute(['userId' => $userId]);
        $data = $stmt->fetch();

        if (empty($data)) {
            return null;
        }

        $obj = new self();
        $obj->id = $data['id'];
        $obj->name = $data['name'];
        $obj->email = $data['email'];
        $obj->password = $data['password'];

        return $obj;
    }


    public function getId(): int
    {
        return $this->id;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getEmail(): string
    {
        return $this->email;
    }

    public function getPassword(): string
    {
        return $this->password;
    }

}