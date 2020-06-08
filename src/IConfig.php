<?php
declare(strict_types=1);

namespace rabbit\ding\robot;

/**
 * Interface IConfig
 * @package rabbit\ding\robot
 */
interface IConfig
{
    public function getConfig(): array;
}