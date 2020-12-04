<?php

declare(strict_types=1);

namespace Rabbit\Ding\Robot\Talk;

class Application
{
    public array $config = [];

    protected array $services = [
        'department' => Department::class,
        'user' => User::class
    ];

    public function __construct(array $config)
    {
        $this->config = $config;
        foreach ($this->services as $name => $service) {
            $this->services[$name] = create($service, ['app' => $this]);
        }
    }

    public function __get($name)
    {
        return $this->services[$name] ?? null;
    }
}
