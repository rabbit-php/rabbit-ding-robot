<?php

declare(strict_types=1);

namespace Rabbit\Ding\Robot\Messages;

class Text extends Message
{
    public function __construct(string $content)
    {
        $this->message = [
            'msgtype' => 'text',
            'text' => [
                'content' => $content
            ]
        ];
    }
}
