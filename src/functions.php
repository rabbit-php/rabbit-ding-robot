<?php

use Rabbit\Ding\Robot\DingTalk;
use Rabbit\Ding\Robot\Talk\Application;

if (!function_exists('ding')) {

    /**
     * @return DingTalk|null
     * @throws Throwable
     */
    function ding(): ?DingTalk
    {
        return getDI('ding.robot');
    }
}

if (!function_exists('talk')) {
    function talk(string $name = 'default'): ?Application
    {
        return getDI('ding.talk')->getApp($name);
    }
}
