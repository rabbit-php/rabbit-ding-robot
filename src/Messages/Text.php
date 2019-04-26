<?php

namespace rabbit\ding\robot\Messages;
/**
 * Class Text
 * @package rabbit\ding\robot\Messages
 */
class Text extends Message
{
    /**
     * Text constructor.
     * @param string $content
     */
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