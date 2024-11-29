<?php

namespace ZWan\Tool\Mutex\Impl\Redis;


use ZWan\Tool\Mutex\Impl\Redis\Application\RedisApplication;
use ZWan\Tool\Mutex\MutexProviderInterface;

class MutexProviderByRedis implements MutexProviderInterface
{
    /**
     * redis实例
     *
     * @var null
     */
    private static $redisApplication = null;

    /**
     * @var MutexProviderByRedis|null
     */
    private static $mutexProvider = null;

    /**
     * 构造函数初始化Redis
     */
    private function __construct()
    {
        self::$redisApplication = RedisApplication::getRedis();
    }

    /**
     * 创建 MutexByRedis
     *
     * @return MutexProviderByRedis
     */
    public static function getMutexProvider(): MutexProviderInterface
    {
        if (self::$mutexProvider === null) {
            self::$mutexProvider = new self();
        }
        return self::$mutexProvider;
    }

    public static function getLock(string $lockName, int $expireTime = 86400)
    {
        $password = self::generatePassword();
        if (!self::$redisApplication->set($lockName, $password, array('nx', 'ex' => $expireTime))) {
            return false;
        }
        return $password;
    }

    public static function unLock(string $lockName, string $password): bool
    {
        $result = self::$redisApplication->get($lockName);

        if ($result === $password) {
            self::$redisApplication->del($lockName);
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