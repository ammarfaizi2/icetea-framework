<?php

namespace System\Crayner\Set;

use System\Crayner\Cookie\Cookie;

class Set
{
    public function __construct()
    {
    }

    public function header($name, $value)
    {
        return header("{$name}: {$value}");
    }

    public function cookie($name, $value, $minute = null, $path = "/", $domain = null, $secure = null, $httpOnly = true)
    {
        return Cookie::getInstance()->make($name, $value, $minute, $path, $domain, $secure, $httpOnly);
    }
}
