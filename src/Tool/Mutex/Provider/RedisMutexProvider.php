<?php

namespace ZWan\Tool\Mutex\Provider;

use ZWan\Tool\Applications\RedisApplication;
use ZWan\Traits\SingletonTrait;

class RedisMutexProvider implements MutexProviderInterface
{
    use SingletonTrait;

    /**
     * redis实例
     *
     * @var null
     */
    private static $redis = null;

    /**
     * RedisMutexProvider
     *
     * @var null
     */
    private static $mutexProvider = null;

    /**
     * 构造函数初始化Redis
     */
    private function __construct()
    {
        self::$redis = RedisApplication::getRedis();
    }

    /**
     * 创建 RedisMutexProvider
     *
     * @return RedisMutexProvider
     */
    public static function getMutexProvider(): RedisMutexProvider
    {
        if (self::$mutexProvider === null) {
            self::$mutexProvider = new self();
        }
        return self::$mutexProvider;
    }

    /**
     * 加锁
     *
     * @param string $lockName
     * @param int $expireTime
     * @return false|string
     */
    public static function getLock(string $lockName, int $expireTime = 86400)
    {
        $password = self::generatePassword();
        if (!self::$redis->set($lockName, $password, array('nx', 'ex' => $expireTime))) {
            return false;
        }
        return $password;
    }

    /**
     * 解锁
     *
     * @param string $lockName
     * @param string $password
     * @return bool
     */
    public static function unLock(string $lockName, string $password): bool
    {
        $result = self::$redis->get($lockName);

        if ($result === $password) {
            self::$redis->del($lockName);
            return true;
        }
        return false;
    }

    /**
     * 生成解锁密钥
     *
     * @return string
     * @throws
     */
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
}