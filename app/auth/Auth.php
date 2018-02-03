<?php namespace App\Auth;

use Slim\Container;

class Auth
{
    private $container;
    const LOGIN = 'admin';
    const PASSWORD = 'trunc';

    private $login;
    private $password;

    /**
     * Auth constructor.
     * @param Container $container
     */
    public function __construct($container)
    {
        $this->container = $container;
        session_start();

        $this->login = $this->container->get('settings')['auth']['login'];
        $this->password = $this->container->get('settings')['auth']['password'];
    }

    public function attempt($login, $password)
    {
        if ($login === $this->login && $password === $this->password) {
            $_SESSION['user'] =  $this->login;
            return true;
        }

        return false;
    }

    public function check()
    {
        return isset($_SESSION['user']) && ($_SESSION['user'] === $this->login);
    }
}
