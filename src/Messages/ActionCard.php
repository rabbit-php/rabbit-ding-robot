<?php

declare(strict_types=1);

namespace Rabbit\Ding\Robot\Messages;

use Rabbit\Ding\Robot\DingTalkService;

class ActionCard extends Message
{
    public function __construct(protected DingTalkService $service, string $title, string $markdown, string $singleTitle = '', int $btnOrientation = 0, $singleURL = '')
    {
        $this->setMessage($title, $markdown, $singleTitle, $btnOrientation, $singleURL);
    }

    public function setMessage(string $title, string $markdown, string $singleTitle = '', int $btnOrientation = 0, $singleURL = ''): void
    {
        $this->message = [
            'msgtype' => 'actionCard',
            'actionCard' => [
                'title' => $title,
                'text' => $markdown,
                'btnOrientation' => $btnOrientation,
                'singleTitle' => $singleTitle,
                'singleURL' => $singleURL,
            ]
        ];
    }

    public function single(string $title, string $url): self
    {
        $this->message['actionCard']['singleTitle'] = $title;
        $this->message['actionCard']['singleURL'] = $url;
        $this->service->setMessage($this);
        return $this;
    }

    public function addButtons(string $title, string $url): self
    {
        $this->message['actionCard']['btns'][] = [
            'title' => $title,
            'actionURL' => $url
        ];
        return $this;
    }

    public function send(): void
    {
        $this->service->setMessage($this);
        $this->service->send();
    }
}
