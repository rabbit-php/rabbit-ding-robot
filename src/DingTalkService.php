<?php
declare(strict_types=1);

namespace Rabbit\Ding\Robot;

use Co\Http\Client;
use Exception;
use Rabbit\Base\Helper\ArrayHelper;
use Rabbit\Ding\Robot\Messages\ActionCard;
use Rabbit\Ding\Robot\Messages\FeedCard;
use Rabbit\Ding\Robot\Messages\Link;
use Rabbit\Ding\Robot\Messages\Markdown;
use Rabbit\Ding\Robot\Messages\Message;
use Rabbit\Ding\Robot\Messages\Text;

/**
 * Class DingTalkService
 * @package Rabbit\Ding\Robot
 */
class DingTalkService
{
    /** @var array */
    protected array $config;
    /**
     * @var string
     */
    protected string $accessToken = "";
    /**
     * @var string
     */
    protected string $accessSecret = "";
    /**
     * @var string
     */
    protected string $hookUrl = "https://oapi.dingtalk.com/robot/send";

    /**
     * @var Message
     */
    protected Message $message;
    /**
     * @var array
     */
    protected array $mobiles = [];
    /**
     * @var bool
     */
    protected bool $atAll = false;

    /**
     * DingTalkService constructor.
     * @param array $config
     */
    public function __construct(array $config)
    {
        $this->config = $config;
        $this->setTextMessage('null');
        $this->setAccessToken();
        $this->setAccessSecret();
    }

    /**
     * @param string $content
     * @return DingTalkService
     */
    public function setTextMessage(string $content): self
    {
        $this->message = new Text($content);
        $this->dealAt();
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
     *
     */
    public function setAccessSecret(): void
    {
        $this->accessSecret = $this->config['secret'] ?? '';
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
        $this->mobiles = empty($mobiles) ? (array)ArrayHelper::getValue($this->config, 'at', []) : $mobiles;
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
        $this->dealAt();
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

        $this->dealAt();
        return $this;
    }

    /**
     * @param string $title
     * @param string $markdown
     * @param string $singleTitle
     * @param int $btnOrientation
     * @param string $singleURL
     * @return DingTalkService
     */
    public function setActionCardMessage(
        string $title,
        string $markdown,
        string $singleTitle = '',
        int $btnOrientation = 0,
        string $singleURL = ''
    ): DingTalkService
    {
        $this->message = new ActionCard($this, $title, $markdown, $singleTitle, $btnOrientation, $singleURL);
        $this->dealAt();
        return $this;
    }

    /**
     * @return DingTalkService
     */
    public function setFeedCardMessage(): self
    {
        $this->message = new FeedCard($this);
        $this->dealAt();
        return $this;
    }

    /**
     * @throws Exception
     */
    public function send(): void
    {
        if (!$this->config['enabled']) {
            return;
        }

        rgo(function () {
            $parsed = parse_url($this->getRobotUrl());
            if (!isset($parsed['path'])) {
                $parsed['path'] = '/';
            }
            $client = new Client($parsed['host'], 443, true);
            $client->set([
                'timeout' => $this->config['timeout']
            ]);
            $client->setHeaders([
                'Content-Type' => 'application/json',
            ]);
            $path = $parsed['path'] . (isset($parsed['query']) ? "?{$parsed['query']}" : '');
            $client->post($path, json_encode($this->message->getBody(), JSON_UNESCAPED_UNICODE));
            $body = (string)$client->getBody();
            $client->close();
            return $body;
        });
    }

    public function getSign(): array
    {
        $t = time() * 1000;
        $ts = $t . "\n" . $this->accessSecret;
        $sig = hash_hmac('sha256', $ts, $this->accessSecret, true);
        $sig = base64_encode($sig);
        $sig = urlencode($sig);
        return [$t, $sig];
    }

    /**
     * @return string
     */
    public function getRobotUrl(): string
    {
        $url = $this->hookUrl . "?access_token={$this->accessToken}";
        if (!empty($this->accessSecret)) {
            [$times, $sign] = $this->getSign();
            $url .= "&timestamp={$times}&sign={$sign}";
        }
        return $url;
    }

    public function dealAt(): void
    {
        $this->message->sendAt($this->mobiles, $this->atAll);
        $this->atAll = false;
        $this->mobiles = [];
    }
}
