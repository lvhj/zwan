<?php

namespace ZWan\Tool\Mutex\Impl\Redis\Application;

use ZWan\Tool\Common\ProviderInterface;
use ZWan\Tool\Mutex\Exception\MutexException;

class RedisApplication implements ProviderInterface
{
    /**
     * redis实例
     *
     * @var null
     */
    private static $redis = null;

    /**
     * @param $redis
     */
    private function __construct($redis)
    {
        self::$redis = $redis;
    }

    public static function getRedis()
    {
        if (self::$redis === null) {
            throw new MutexException("Redis instance not defined");
        }
        return self::$redis;
    }

    public static function register($handlerService)
    {
        if ($handlerService === null) {
            throw new MutexException("handler service can not be null");
        }

        if (self::$redis === null) {
            new self($handlerService);
        } else {
            throw new MutexException("redis instance has already been registered");
        }
    }

    public static function clear()
    {
        self::$redis = null;
    }
}