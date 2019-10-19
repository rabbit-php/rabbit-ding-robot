<?php

namespace rabbit\ding\robot\Messages;

use rabbit\ding\robot\DingTalkService;

/**
 * Class ActionCard
 * @package rabbit\ding\robot\Messages
 */
class ActionCard extends Message
{
    /** @var DingTalkService */
    protected $service;

    /**
     * ActionCard constructor.
     * @param DingTalkService $service
     * @param string $title
     * @param string $markdown
     * @param int $hideAvatar
     * @param int $btnOrientation
     */
    public function __construct(DingTalkService $service, string $title, string $markdown, int $hideAvatar = 0, int $btnOrientation = 0)
    {
        $this->service = $service;
        $this->setMessage($title, $markdown, $hideAvatar, $btnOrientation);
    }

    /**
     * @param string $title
     * @param string $markdown
     * @param int $hideAvatar
     * @param int $btnOrientation
     */
    public function setMessage(string $title, string $markdown, int $hideAvatar = 0, int $btnOrientation = 0)
    {
        $this->message = [
            'msgtype' => 'actionCard',
            'actionCard' => [
                'title' => $title,
                'text' => $markdown,
                'hideAvatar' => $hideAvatar,
                'btnOrientation' => $btnOrientation
            ]
        ];
    }

    /**
     * @param string $title
     * @param string $url
     * @return ActionCard
     */
    public function single(string $title, string $url): self
    {
        $this->message['actionCard']['singleTitle'] = $title;
        $this->message['actionCard']['singleURL'] = $url;
        $this->service->setMessage($this);
        return $this;
    }

    /**
     * @param string $title
     * @param string $url
     * @return ActionCard
     */
    public function addButtons(string $title, string $url): self
    {
        $this->message['actionCard']['btns'][] = [
            'title' => $title,
            'actionURL' => $url
        ];
        return $this;
    }

    /**
     *
     */
    public function send(): void
    {
        $this->service->setMessage($this);
        $this->service->send();
    }
}
