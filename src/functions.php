<?php

use Rabbit\Ding\Robot\DingTalk;

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
    function talk(string $name = 'default'): ?\EasyDingTalk\Application
    {
        return getDI('ding.talk')->getApp($name);
    }
}
