<?php

declare(strict_types=1);

namespace Rabbit\Ding\Robot;

use Rabbit\Base\Core\Exception;

/**
 * Class DingHelper
 * @package Ding
 */
class DingHelper
{
    /**
     * @param array $response
     * @throws Exception
     */
    public static function checkResponse(array $response): void
    {
        if ($response['errcode'] !== 0) {
            throw new Exception($response['errmsg']);
        }
    }
}
