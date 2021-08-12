<?php

declare(strict_types=1);

namespace Rabbit\Ding\Robot\Messages;

class Link extends Message
{
    public function __construct(string $title, string $text, string $messageUrl, string $picUrl = '')
    {
        $this->setMessage($title, $text, $messageUrl, $picUrl);
    }

    public function setMessage(string $title, string $text, string $messageUrl, string $picUrl = ''): void
    {
        $this->message = [
            'msgtype' => 'link',
            'link' => [
                'text' => $text,
                'title' => $title,
                'picUrl' => $picUrl,
                'messageUrl' => $messageUrl
            ]
        ];
    }
}
