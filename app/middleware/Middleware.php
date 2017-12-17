<?php namespace App\Middleware;

class Middleware
{
    protected $container;
    public function __construct($container)
    {
        $this->container = $container;
    }

    public function check()
    {
        return false;
    }
}