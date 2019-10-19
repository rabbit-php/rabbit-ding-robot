<?php

namespace rabbit\ding\robot\Messages;

/**
 * Class Link
 * @package rabbit\ding\robot\Messages
 */
class Link extends Message
{
    /**
     * Link constructor.
     * @param string $title
     * @param string $text
     * @param string $messageUrl
     * @param string $picUrl
     */
    public function __construct(string $title, string $text, string $messageUrl, string $picUrl = '')
    {
        $this->setMessage($title, $text, $messageUrl, $picUrl);
    }

    /**
     * @param string $title
     * @param string $text
     * @param string $messageUrl
     * @param string $picUrl
     */
    public function setMessage(string $title, string $text, string $messageUrl, string $picUrl = '')
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
