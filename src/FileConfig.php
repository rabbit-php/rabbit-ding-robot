<?php
declare(strict_types=1);

namespace Rabbit\Ding\Robot;

/**
 * Class FileConfig
 * @package Rabbit\Ding\Robot
 */
class FileConfig implements IConfig
{
    protected array $config;

    public function __construct(array $config)
    {
        $this->config = $config;
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