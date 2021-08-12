<?php

namespace Rabbit\Ding\Robot\Messages;

use Rabbit\Ding\Robot\DingTalkService;

abstract class Message
{
    protected array $message = [];
    protected array $at;

    public function getMessage(): array
    {
        return $this->message;
    }

    public function getBody(): array
    {
        if (empty($this->at)) {
            $this->sendAt();
        }
        return $this->message + $this->at;
    }

    public function sendAt(array $mobiles = [], bool $atAll = false): self
    {
        $this->at = $this->makeAt($mobiles, $atAll);
        return $this;
    }

    protected function makeAt(array $mobiles = [], bool $atAll = false): array
    {
        return [
            'at' => [
                'atMobiles' => $mobiles,
                'isAtAll' => $atAll
            ]
        ];
    }
}
