<?php

declare(strict_types=1);

namespace Rabbit\Ding\Robot\Talk;

class Application
{
    protected array $services = [
        'department' => Department::class,
        'user' => User::class
    ];

    public function __construct(public readonly array $config)
    {
        foreach ($this->services as $name => $service) {
            $this->services[$name] = create($service, ['app' => $this]);
        }
    }

    public function __get($name)
    {
        return $this->services[$name] ?? null;
    }
}
