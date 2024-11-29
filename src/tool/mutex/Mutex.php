<?php

namespace ZWan\Tool\Mutex;

use ZWan\Tool\Mutex\Exception\MutexException;
use ZWan\tool\mutex\impl\redis\MutexProviderByRedis;

class Mutex
{
    /**
     * @var string
     */
    private $lockName;

    /**
     * @var null|int|bool
     */
    private $lockPassword = null;

    /**
     * 互斥锁
     *
     * @var MutexProviderByRedis|MutexProviderInterface|null
     */
    private static $mutexProvider = null;

    /**
     * @param string $lockName
     * @param MutexProviderInterface|null $mutexProvider
     */
    private function __construct(string $lockName, MutexProviderInterface $mutexProvider = null)
    {
        $this->lockName = $lockName;
    }

    /**
     * @param MutexProviderInterface|null $mutexProvider
     * @return void
     */
    public static function register(MutexProviderInterface $mutexProvider = null)
    {
        if (self::$mutexProvider === null) {
            self::$mutexProvider =
                ($mutexProvider === null ? MutexProviderByRedis::getMutexProvider() : $mutexProvider);
        } else {
            throw new MutexException("mutexProvider has already been registered");
        }
    }

    /**
     * @return void
     */
    public static function clear()
    {
        self::$mutexProvider = null;
    }

    /**
     * 获取一个锁
     * @param string $lockName
     * @param MutexProviderInterface|null $mutexProvider
     * @return Mutex
     */
    public static function getLock(string $lockName, MutexProviderInterface $mutexProvider = null): Mutex
    {
        return new Mutex($lockName, $mutexProvider);
    }

    /**
     * 对接下来的调用进行锁定
     * @param callable $callback
     * @param int $expireTime
     * @return mixed
     * @throws
     */
    public function synchronized(callable $callback, int $expireTime = 600)
    {
        if ($this->tryLock($expireTime)) {
            try {
                return $callback();
            } catch (\Throwable $e) {
                throw $e;
            } finally {
                $this->unlock();
            }
        } else {
            throw new MutexException("{$this->lockName} lock fail, try it later");
        }
    }

    /**
     * 尝试加锁
     * @param int $expireTime 自动解锁时间
     * @return bool
     */
    public function tryLock(int $expireTime = 86400): bool
    {
        $lockPassword = self::$mutexProvider::getLock($this->lockName, $expireTime);
        if ($lockPassword === false) {
            return false;
        }

        $this->lockPassword = $lockPassword;
        return true;
    }

    /**
     * 对当前操作进行解锁
     */
    public function unlock()
    {
        if ($this->lockPassword === null) {
            throw new MutexException("try to unlock of unlocked Mutex");
        }

        if (self::$mutexProvider::unlock($this->lockName, $this->lockPassword)) {
            $this->lockPassword = null;
        } else {
            throw new MutexException("try to unlock of expired Mutex");
        }
    }
}