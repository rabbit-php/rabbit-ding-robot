<?php

declare(strict_types=1);

namespace Rabbit\Ding\Robot\Messages;

use Rabbit\Ding\Robot\DingTalkService;

class FeedCard extends Message
{
    public function __construct(protected DingTalkService $service)
    {
        $this->setMessage();
    }

    public function setMessage(): void
    {
        $this->message = [
            'feedCard' => [
                'links' => []
            ],
            'msgtype' => 'feedCard'
        ];
    }

    public function addLinks(string $title, string $messageUrl, string $picUrl): self
    {
        $this->message['feedCard']['links'][] = [
            'title' => $title,
            'messageURL' => $messageUrl,
            'picURL' => $picUrl
        ];
        return $this;
    }

    public function send(): void
    {
        $this->service->setMessage($this);
        $this->service->send();
    }
}
