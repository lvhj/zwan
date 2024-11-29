<?php

namespace ZWan\Tool\Mutex\Impl;

use ZWan\Tool\Mutex\Exception\MutexException;
use ZWan\Tool\Mutex\MutexProviderInterface;

class RedisMutex implements MutexProviderInterface
{
    /**
     * redis实例
     *
     * @var null
     */
    private static $redisInstance = null;

    /**
     * 构造函数初始化Redis
     *
     * @param $redis
     */
    private function __construct($redis)
    {
        if ($redis) {
            self::$redisInstance = $redis;
        }
    }

    /**
     * 创建 RedisMutex
     *
     * @param $redis
     * @return RedisMutex
     */
    public static function getRedisMutex($redis = null): RedisMutex
    {
        if (self::$redisInstance === null && $redis = null) {
            throw new MutexException("Redis instance not defined");
        }

        if (self::$redisInstance === null) {
            self::$redisInstance = new self($redis);
        }
        return self::$redisInstance;
    }

    public static function getLock(string $lockName, int $expireTime = 86400)
    {
        $redis = self::$redisInstance;
        $password = self::generatePassword();
        if ($redis->set($lockName, $password, $expireTime)) {
            return false;
        }
        return $password;
    }

    public static function unLock(string $lockName, string $password): bool
    {
        $redis = self::$redisInstance;
        $result = $redis->get($lockName);
        if ($result === $password) {
            $redis->del($lockName);
            return true;
        }
        return false;
    }

    // 生成唯一的 TraceId
    private static function generatePassword(): string
    {
        // 获取当前时间戳，确保一定的唯一性
        $timestamp = microtime(true);

        // 获取机器的唯一标识符（比如IP地址、机器ID等）
        $hostname = gethostname();

        // 生成一个随机数增加不可预测性
        $random = bin2hex(random_bytes(8));  // 随机生成16进制字符串

        // 组合成traceId
        return sprintf('%s-%s-%s', $hostname, $timestamp, $random);
    }

    /**
     * 禁止克隆
     *
     * @return void
     */
    private function __clone()
    {
    }

    /**
     * 禁止反序列化
     *
     * @return void
     */
    private function __wakeup()
    {
    }
}