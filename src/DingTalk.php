<?php

namespace Rabbit\Ding\Robot;

use Exception;
use Rabbit\Ding\Robot\Messages\ActionCard;

/**
 * Class DingTalk
 * @package Rabbit\Ding\Robot
 */
class DingTalk
{

    /**
     * @var array
     */
    protected array $config;
    /**
     * @var string
     */
    protected string $robot = 'default';
    /**
     * @var DingTalkService
     */
    protected DingTalkService $dingTalkService;

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
     * @throws Exception
     */
    public function text(string $content = ''): void
    {
        $this->dingTalkService->setTextMessage($content)->send();
    }

    /**
     * @param string $title
     * @param string $text
     * @return DingTalkService
     */
    public function action(string $title, string $text): DingTalkService
    {
        return $this->dingTalkService->setActionCardMessage($title, $text);
    }

    /**
     * @param array $mobiles
     * @param bool $atAll
     * @return DingTalk
     */
    public function at(array $mobiles = [], bool $atAll = false): self
    {
        $this->dingTalkService->setAt($mobiles, $atAll);
        return $this;
    }

    /**
     * @param string $title
     * @param string $text
     * @param string $url
     * @param string $picUrl
     * @throws Exception
     */
    public function link(string $title, string $text, string $url, string $picUrl = ''): void
    {
        $this->dingTalkService->setLinkMessage($title, $text, $url, $picUrl)->send();
    }

    /**
     * @param string $title
     * @param string $markdown
     * @throws Exception
     */
    public function markdown(string $title, string $markdown): void
    {
        $this->dingTalkService->setMarkdownMessage($title, $markdown)->send();
    }

    /**
     * @param string $title
     * @param string $markdown
     * @param string $singleTitle
     * @param int $btnOrientation
     * @param string $singleURL
     * @throws Exception
     */
    public function actionCard(string $title, string $markdown, string $singleTitle = '', int $btnOrientation = 0, $singleURL = ''): void
    {
        $this->dingTalkService->setActionCardMessage($title, $markdown, $singleTitle, $btnOrientation, $singleURL)->send();
    }

    /**
     * @return DingTalkService
     */
    public function feed(): DingTalkService
    {
        return $this->dingTalkService->setFeedCardMessage();
    }
}
