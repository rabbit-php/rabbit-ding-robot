<?php

declare(strict_types=1);

namespace Rabbit\Ding\Robot;

/**
 * Class FileConfig
 * @package Rabbit\Ding\Robot
 */
class FileConfig implements IConfig
{
    public function __construct(protected array $config)
    {
    }

    /**
     * @return array
     */
    public function getConfig(): array
    {
        return $this->config;
    }

    /**
     * @param array $config
     */
    public function setConfig(array $config): void
    {
        $this->config = $config;
    }
}
