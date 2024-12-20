<?php

namespace ZWan\Tool\Applications;

use ZWan\Tool\Applications\Exceptions\ApplicationException;

class RedisApplication
{
    /**
     * redis实例
     *
     * @var null
     */
    private static $redis = null;

    /**
     * 设置 Redis 实例
     */
    public static function setRedis($redis)
    {
        if (self::$redis === null) {
            self::$redis = $redis;
        }
    }

    /**
     * 获取 Redis 实例
     */
    public static function getRedis()
    {
        if (empty(self::$redis)) {
            throw ApplicationException::REDIS_APPLICATION_IS_NOT_EXISTED();
        }
        return self::$redis;
    }
}