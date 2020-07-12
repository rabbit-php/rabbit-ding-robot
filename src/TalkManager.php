<?php
declare(strict_types=1);

namespace Rabbit\Ding\Robot;

use EasyDingTalk\Application;
use Rabbit\Base\Core\Exception;

/**
 * Class TalkManager
 * @package Rabbit\Ding\Robot
 */
class TalkManager
{
    /** @var array */
    protected array $apps = [];

    /**
     * TalkManager constructor.
     * @param array $config
     */
    public function __construct(array $config)
    {
        $this->addConfig($config);
    }

    /**
     * @param array $config
     */
    public function addConfig(array $config): void
    {
        foreach ($config as $name => $item) {
            if ($item instanceof IConfig) {
                $this->apps[$name] = new Application($item->getConfig());
            }
        }
    }

    /**
     * @param string $name
     * @return Application|null
     * @throws Exception
     */
    public function getApp(string $name): ?Application
    {
        if (isset($this->apps[$name])) {
            return $this->apps[$name];
        }
        throw new Exception("Ding talk has no $name config");
    }
}