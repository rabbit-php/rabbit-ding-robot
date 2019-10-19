<?php

namespace rabbit\ding\robot\Messages;

/**
 * Class Markdown
 * @package rabbit\ding\robot\Messages
 */
class Markdown extends Message
{
    /**
     * Markdown constructor.
     * @param $title
     * @param $markdown
     */
    public function __construct(string $title, string $markdown)
    {
        $this->setMessage($title, $markdown);
    }

    /**
     * @param string $title
     * @param string $markdown
     */
    public function setMessage(string $title, string $markdown)
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
