<?php

namespace Service\Auth;

use Model\User;

class AuthCookieService implements AuthServiceInterface
{
    public function check(): bool
    {
        return isset($_COOKIE['user_id']);
    }


    public function getCurrentUser(): ?User
    {
        if (!$this->check()) {
            return null;
        }

        $userId = $_COOKIE['user_id'];
        return User::getById($userId);
    }


    public function login(string $login, string $password): bool
    {
        $data=User::getByLogin($login);

        if (($data !== null) and password_verify($password, $data->getPassword())) {
            setcookie('user_id', $data->getId());
            return true;
        }
        return false;
    }

}