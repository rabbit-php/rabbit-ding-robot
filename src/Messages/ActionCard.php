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
    public function __construct(DingTalkService $service, string $title, string $markdown, string $singleTitle = '', int $btnOrientation = 0, $singleURL='')
    {
        $this->service = $service;
        $this->setMessage($title, $markdown, $singleTitle, $btnOrientation, $singleURL);
    }

    /**
     * @param string $title
     * @param string $markdown
     * @param string $singleTitle
     * @param int $btnOrientation
     * @param string $singleURL
     */
    public function setMessage(string $title, string $markdown, string $singleTitle = '', int $btnOrientation = 0, $singleURL='')
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
