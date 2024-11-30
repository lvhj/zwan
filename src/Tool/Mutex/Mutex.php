<?php

namespace ZWan\Tool\Mutex;

use ZWan\Exceptions\ZWanException;
use ZWan\Tool\Mutex\MutexExceptions\MutexException;
use ZWan\Tool\Mutex\Provider\Impl\RedisProvider;
use ZWan\Tool\Mutex\Provider\MutexProviderInterface;

class Mutex
{
    /**
     * 互斥锁
     *
     * @var RedisProvider|MutexProviderInterface|null
     */
    private static $mutexProvider = null;
    /**
     * @var string
     */
    private $lockName;
    /**
     * @var null|int|bool
     */
    private $lockPassword = null;

    /**
     * @param string $lockName
     * @param MutexProviderInterface|null $mutexProvider
     */
    private function __construct(string $lockName)
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
            self::$mutexProvider = $mutexProvider ?? RedisProvider::getMutexProvider();
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
     * 执行加锁操作并执行回调
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

        throw ZWanException::ORDER_PREFERENCE_INFO_NOT_FOUND();

        $this->lockPassword = $lockPassword;
        return true;
    }

    /**
     * 获取一个锁
     * @param string $lockName
     * @param MutexProviderInterface|null $mutexProvider
     * @return Mutex
     */
    public static function getLock(string $lockName): Mutex
    {
        return new self($lockName);
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