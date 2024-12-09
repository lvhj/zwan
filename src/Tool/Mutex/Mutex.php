<?php

namespace ZWan\Tool\Mutex;

use ZWan\Tool\Mutex\Exceptions\MutexException;
use ZWan\Tool\Mutex\Provider\MutexProviderInterface;
use ZWan\Tool\Mutex\Provider\RedisMutexProvider;

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
     * @var MutexProviderInterface|null
     */
    private static $mutexProvider = null;

    /**
     * @param string $lockName
     */
    private function __construct(string $lockName)
    {
        self::$mutexProvider = RedisMutexProvider::getMutexProvider();
        $this->lockName = $lockName;
    }

    /**
     * 获取互斥锁
     * @param string $lockName
     * @return Mutex
     */
    public static function getLock(string $lockName): Mutex
    {
        return new self($lockName);
    }

    /**
     * 执行加锁并执行回调函数
     *
     *
     * @param callable $callback 执行的回调函数
     * @param int $expireTime 锁的过期时间，单位秒
     * @return mixed
     * @throws MutexException|\Throwable
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
            throw MutexException::TRY_TO_UNLOCK_OF_UNLOCKED_MUTEX();
        }

        if (self::$mutexProvider::unlock($this->lockName, $this->lockPassword)) {
            $this->lockPassword = null;
        } else {
            throw MutexException::TRY_TO_UNLOCK_OF_EXPIRED_MUTEX();
        }
    }
}