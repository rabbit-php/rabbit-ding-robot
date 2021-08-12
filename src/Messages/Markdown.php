<?php

declare(strict_types=1);

namespace Rabbit\Ding\Robot\Messages;

class Markdown extends Message
{
    public function __construct(string $title, string $markdown)
    {
        $this->setMessage($title, $markdown);
    }

    public function setMessage(string $title, string $markdown): void
    {
        $this->message = [
            'msgtype' => 'markdown',
            'markdown' => [
                'title' => $title,
                'text' => $markdown
            ]
        ];
    }
}
