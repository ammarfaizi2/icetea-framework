<?php

namespace System\Crayner\Get;

use System\Crayner\Cookie\Cookie;

class Get
{
    public function __construct()
    {
    }

    public function cookie($name)
    {
        return Cookie::getInstance()->get($name);
    }

    public function header($name)
    {
    }
}
