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
