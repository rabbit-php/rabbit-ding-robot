<?php

namespace rabbit\ding\robot;

use rabbit\ding\robot\Messages\ActionCard;
use rabbit\ding\robot\Messages\FeedCard;

/**
 * Class DingTalk
 * @package rabbit\ding\robot
 */
class DingTalk
{

    /**
     * @var array
     */
    protected $config;
    /**
     * @var string
     */
    protected $robot = 'default';
    /**
     * @var DingTalkService
     */
    protected $dingTalkService;

    /**
     * DingTalk constructor.
     * @param array $config
     */
    public function __construct(array $config)
    {
        $this->config = $config;
        $this->with();
    }

    /**
     * @param string $robot
     * @return DingTalk
     */
    public function with(string $robot = 'default'): self
    {
        $this->robot = $robot;
        $this->dingTalkService = new DingTalkService($this->config[$robot]);
        return $this;
    }


    /**
     * @param string $content
     * @throws \Exception
     */
    public function text(string $content = ''): void
    {
        $this->dingTalkService
            ->setTextMessage($content)
            ->send();
    }

    /**
     * @param string $title
     * @param string $text
     * @return ActionCard
     */
    public function action(string $title, string $text): ActionCard
    {
        return $this->dingTalkService
            ->setActionCardMessage($title, $text);
    }

    /**
     * @param array $mobiles
     * @param bool $atAll
     * @return DingTalk
     */
    public function at(array $mobiles = [], bool $atAll = false): self
    {
        $this->dingTalkService
            ->setAt($mobiles, $atAll);
        return $this;
    }

    /**
     * @param string $title
     * @param string $text
     * @param string $url
     * @param string $picUrl
     * @throws \Exception
     */
    public function link(string $title, string $text, string $url, string $picUrl = ''): void
    {
        $this->dingTalkService
            ->setLinkMessage($title, $text, $url, $picUrl)
            ->send();
    }

    /**
     * @param string $title
     * @param string $markdown
     * @throws \Exception
     */
    public function markdown(string $title, string $markdown): void
    {
        $this->dingTalkService
            ->setMarkdownMessage($title, $markdown)
            ->send();
    }

    /**
     * @param string $title
     * @param string $markdown
     * @param int $hideAvatar
     * @param int $btnOrientation
     * @return ActionCard|Messages\Message
     */
    public function actionCard(string $title, string $markdown, int $hideAvatar = 0, int $btnOrientation = 0): ActionCard
    {
        return $this->dingTalkService
            ->setActionCardMessage($title, $markdown, $hideAvatar, $btnOrientation);
    }

    /**
     * @return FeedCard
     */
    public function feed(): FeedCard
    {
        return $this->dingTalkService
            ->setFeedCardMessage();
    }

}