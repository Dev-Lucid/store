<?php
namespace DevLucid\Component\Store;

class Cookie extends Store
{
    public function __construct()
    {
        $this->source = $_COOKIE;
    }

    public function set(string $name, $newValue, $additionalParameter=null)
    {
        if (is_null($additionalParameter) === true) {
            # by default, cookies will expire in 30 days
            $additionalParameter = 2592000;
        }
        setcookie($name, $newValue, (time() + $additionalParameter));
        return $this;
    }
}
