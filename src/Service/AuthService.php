<?php

namespace Service;

use Model\User;
class AuthService
{
    public function check(): bool
    {
        $this->sessionStart();
        return isset($_SESSION['user_id']);
    }


    public function getCurrentUser(): ?User
    {
        if (!$this->check()) {
            return null;
        }

        $this->sessionStart();
        $userId = $_SESSION['user_id'];
        return User::getById($userId);
    }


    public function login(string $login, string $password): bool
    {
        $data=User::getByLogin($login);

        if (($data !== null) and password_verify($password, $data->getPassword())) {
            $this->sessionStart();
            $_SESSION['user_id'] = $data->getId();
            return true;
        }
        return false;
    }


    private function sessionStart()
    {
        if (session_status() !== PHP_SESSION_ACTIVE) {
            session_start();
        }
    }
}