<?php
/**
 * Sunny 2020/12/14 下午4:42
 * ogg sit down and start building bugs.
 * Author: Ogg <baoziyoo@gmail.com>
 */

namespace App\Models\User\Provider;

class CurrentUserProvider
{
    private static $user;

    public function __set($name, $value)
    {
        self::$user[$name] = $value;

        return $this;
    }

    public function __get($name)
    {
        if (array_key_exists($name, self::$user)) {
            return self::$user[$name];
        }

        throw new \InvalidArgumentException("{$name} is not exist in CurrentUser.");
    }

    public function __isset($name)
    {
        return isset(self::$user[$name]);
    }

    public function __unset($name)
    {
        unset(self::$user[$name]);
    }

    public function setUser($user)
    {
        return self::$user = $user;
    }

    public function getId()
    {
        return $this->id;
    }

    public function getGuid()
    {
        return $this->guid;
    }

    public function getForm()
    {
        return $this->form;
    }
}
