<?php namespace App\Widgets;

class Widget
{
    protected $html;
    public function __toString()
    {
        return $this->html;
    }
}