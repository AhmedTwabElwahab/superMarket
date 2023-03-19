<?php

namespace App\helper;

class Language
{
    protected $controller;
    protected $method;

    function __construct($controller, $method)
    {
        $this->controller = $controller;
        $this->method     = $method;
    }

    public function text(string $text,array $options = [])
    {
        return __($this->controller.'\\'.$this->method.'.'.$text,$options);
    }

    public function sideMenu(string $text)
    {
        return __('layouts\sideMenu.'.$text);
    }

    public function nav(string $text)
    {
        return __('layouts\nav.'.$text);
    }
}
