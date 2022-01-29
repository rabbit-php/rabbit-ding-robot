<?php

use Rabbit\Ding\Robot\DingTalk;
use Rabbit\Ding\Robot\Talk\Application;

if (!function_exists('ding')) {

    /**
     * @return DingTalk|null
     * @throws Throwable
     */
    function ding(string $key = 'default'): ?DingTalk
    {
        return service('ding.robot')->get($key);
    }
}

if (!function_exists('talk')) {
    function talk(string $name = 'default'): ?Application
    {
        return service('ding.talk')->getApp($name);
    }
}
