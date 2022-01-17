<?php

declare(strict_types=1);

namespace Rabbit\Ding\Robot\Talk;

use GuzzleHttp\Psr7\Request;
use Psr\Http\Message\RequestInterface;
use Rabbit\Base\Exception\InvalidArgumentException;
use Rabbit\Cache\Cache;
use Rabbit\HttpClient\Client;

abstract class BaseClient
{
    protected Client $client;

    protected Cache $cache;

    protected ?string $cacheKey = null;

    protected static $httpConfig = [
        'base_uri' => 'https://oapi.dingtalk.com',
    ];

    public function __construct(protected Application $app, array $options = [])
    {
        $this->client = new Client($options + self::$httpConfig + [
            'before' => function (RequestInterface $request) {
                parse_str($request->getUri()->getQuery(), $query);
                $request = $request->withUri(
                    $request->getUri()->withQuery(http_build_query(['access_token' => $this->getAccessToken()] + $query))
                );
                if ($request instanceof Request) {
                    return $request;
                }
            }
        ]);
        $this->cache = getDI('cache');
        $this->cacheKey = sprintf('access_token.%s', $app->config['app_key']);
    }

    public function getAccessToken(): string
    {
        $token = $this->cache->get($this->cacheKey);
        if (is_string($token) && strlen($token) > 0) {
            return $token;
        }
        $response = (new Client(self::$httpConfig))->get('gettoken', ['query' => [
            'appkey' => $this->app->config['app_key'],
            'appsecret' => $this->app->config['app_secret'],
        ]]);
        $value = $response->jsonArray();
        if (0 !== $value['errcode']) {
            throw new InvalidArgumentException(json_encode($value));
        }
        $this->cache->set($this->cacheKey, $value['access_token'], $value['expires_in']);
        return $value['access_token'];
    }
}
