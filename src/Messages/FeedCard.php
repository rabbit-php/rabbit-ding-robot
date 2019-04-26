<?php

namespace rabbit\ding\robot\Messages;

use rabbit\ding\robot\DingTalkService;

/**
 * Class FeedCard
 * @package rabbit\ding\robot\Messages
 */
class FeedCard extends Message
{
    /** @var DingTalkService */
    protected $service;

    /**
     * FeedCard constructor.
     * @param DingTalkService $service
     */
    public function __construct(DingTalkService $service)
    {
        $this->service = $service;
        $this->setMessage();

    }

    /**
     *
     */
    public function setMessage(): void
    {
        $this->message = [
            'feedCard' => [
                'links' => []
            ],
            'msgtype' => 'feedCard'
        ];
    }

    /**
     * @param string $title
     * @param string $messageUrl
     * @param string $picUrl
     * @return FeedCard
     */
    public function addLinks(string $title, string $messageUrl, string $picUrl): self
    {
        $this->message['feedCard']['links'][] = [
            'title' => $title,
            'messageURL' => $messageUrl,
            'picURL' => $picUrl
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