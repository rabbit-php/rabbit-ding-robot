<?php

use rabbit\ding\robot\DingTalk;

/**
 *
 */
if (!function_exists('ding')) {

    /**
     * @return bool|DingTalk
     */
    function ding()
    {
        return getDI('ding.robot');
    }
}

if (!function_exists('talk')) {
    function talk(string $name = 'default'): \EasyDingTalk\Application
    {
        return getDI('ding.talk')->getApp($name);
    }
}
