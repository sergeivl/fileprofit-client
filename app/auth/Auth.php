<?php namespace App\Auth;

class Auth
{
    const LOGIN = 'admin';
    const PASSWORD = 'trunc';

    public function __construct()
    {
        session_start();
    }

    public function attempt($login, $password)
    {
        if ($login === self::LOGIN && $password === self::PASSWORD) {
            $_SESSION['user'] =  self::LOGIN;
            return true;
        }

        return false;
    }

    public function check()
    {
        return isset($_SESSION['user']) && ($_SESSION['user'] === self::LOGIN);
    }
}
