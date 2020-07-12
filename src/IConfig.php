<?php
declare(strict_types=1);

namespace Rabbit\Ding\Robot;

/**
 * Interface IConfig
 * @package Rabbit\Ding\Robot
 */
interface IConfig
{
    public function getConfig(): array;
}