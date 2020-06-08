<?php
declare(strict_types=1);

namespace rabbit\ding\robot;

/**
 * Class FileConfig
 * @package rabbit\ding\robot
 */
class FileConfig implements IConfig
{
    protected $config;

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