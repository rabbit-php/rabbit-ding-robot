<?php

namespace rabbit\ding\robot\Messages;
/**
 * Class Message
 * @package rabbit\ding\robot\Messages
 */
abstract class Message
{
    /** @var array */
    protected $message = [];
    /** @var array */
    protected $at;

    /**
     * @return array
     */
    public function getMessage(): array
    {
        return $this->message;
    }

    /**
     * @param array $mobiles
     * @param bool $atAll
     * @return array
     */
    protected function makeAt(array $mobiles = [], bool $atAll = false): array
    {
        return [
            'at' => [
                'atMobiles' => $mobiles,
                'isAtAll' => $atAll
            ]
        ];
    }

    /**
     * @param array $mobiles
     * @param bool $atAll
     * @return $this
     */
    public function sendAt(array $mobiles = [], bool $atAll = false): self
    {
        $this->at = $this->makeAt($mobiles, $atAll);
        return $this;
    }

    /**
     * @return array
     */
    public function getBody(): array
    {

        if (empty($this->at)) {
            $this->sendAt();
        }
        return $this->message + $this->at;
    }

}