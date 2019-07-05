<?php

namespace rabbit\ding\robot;

use Exception;
use rabbit\ding\robot\Messages\ActionCard;
use rabbit\ding\robot\Messages\FeedCard;
use rabbit\ding\robot\Messages\Link;
use rabbit\ding\robot\Messages\Markdown;
use rabbit\ding\robot\Messages\Message;
use rabbit\ding\robot\Messages\Text;
use rabbit\helper\CoroHelper;
use Swlib\Saber;

/**
 * Class DingTalkService
 * @package rabbit\ding\robot
 */
class DingTalkService
{
    /** @var array */
    protected $config;
    /**
     * @var string
     */
    protected $accessToken = "";
    /**
     * @var string
     */
    protected $hookUrl = "https://oapi.dingtalk.com/robot/send";

    /**
     * @var Message
     */
    protected $message;
    /**
     * @var array
     */
    protected $mobiles = [];
    /**
     * @var bool
     */
    protected $atAll = false;
    /** @var Saber */
    protected $client;

    /**
     * DingTalkService constructor.
     * @param array $config
     */
    public function __construct(array $config, array $options = [])
    {
        $this->config = $config;
        $this->setTextMessage('null');
        $this->setAccessToken();
        $this->client = Saber::create(array_merge([
            'use_pool' => false,
            'timeout' => 3,
            'retry_time' => 3
        ], $options));
    }

    /**
     * @param string $content
     * @return DingTalkService
     */
    public function setTextMessage(string $content): self
    {
        $this->message = new Text($content);
        $this->message->sendAt($this->mobiles, $this->atAll);
        return $this;
    }

    /**
     *
     */
    public function setAccessToken(): void
    {
        $this->accessToken = $this->config['token'];
    }

    /**
     * @return array
     */
    public function getMessage(): array
    {
        return $this->message->getMessage();
    }

    /**
     * @param Message $message
     */
    public function setMessage(Message $message)
    {
        $this->message = $message;
    }

    /**
     * @param array $mobiles
     * @param bool $atAll
     */
    public function setAt(array $mobiles = [], bool $atAll = false): void
    {
        $this->mobiles = $mobiles;
        $this->atAll = $atAll;
        if ($this->message) {
            $this->message->sendAt($mobiles, $atAll);
        }
    }

    /**
     * @param string $title
     * @param string $text
     * @param string $messageUrl
     * @param string $picUrl
     * @return DingTalkService
     */
    public function setLinkMessage(string $title, string $text, string $messageUrl, string $picUrl = ''): self
    {
        $this->message = new Link($title, $text, $messageUrl, $picUrl);
        $this->message->sendAt($this->mobiles, $this->atAll);
        return $this;
    }

    /**
     * @param string $title
     * @param string $markdown
     * @return DingTalkService
     */
    public function setMarkdownMessage(string $title, string $markdown): self
    {
        $this->message = new Markdown($title, $markdown);
        $this->message->sendAt($this->mobiles, $this->atAll);
        return $this;
    }

    /**
     * @param string $title
     * @param string $markdown
     * @param int $hideAvatar
     * @param int $btnOrientation
     * @return ActionCard
     */
    public function setActionCardMessage(
        string $title,
        string $markdown,
        int $hideAvatar = 0,
        int $btnOrientation = 0
    ): ActionCard {
        $this->message = new ActionCard($this, $title, $markdown, $hideAvatar, $btnOrientation);
        $this->message->sendAt($this->mobiles, $this->atAll);
        return $this->message;
    }

    /**
     * @return FeedCard
     */
    public function setFeedCardMessage(): FeedCard
    {
        $this->message = new FeedCard($this);
        $this->message->sendAt($this->mobiles, $this->atAll);
        return $this->message;
    }

    /**
     * @throws Exception
     */
    public function send(): void
    {
        if (!$this->config['enabled']) {
            return;
        }

        CoroHelper::go(function () {
            $request = $this->client->post($this->getRobotUrl(), $this->message->getBody(), [
                'headers' => [
                    'Content-Type' => 'application/json',
                ],
                'timeout' => $this->config['timeout'] ?? 2.0,
            ]);

            $result = (string)$request->getBody();
            return $result;
        });
    }

    /**
     * @return string
     */
    public function getRobotUrl(): string
    {
        return $this->hookUrl . "?access_token={$this->accessToken}";
    }

}