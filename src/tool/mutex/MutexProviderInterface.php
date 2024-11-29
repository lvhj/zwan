<?php

namespace ZWan\Tool\Mutex;

interface MutexProviderInterface
{
    /**
     * @param string $lockName
     * @param int $expireTime
     * @return int|bool
     */
    public static function getLock(string $lockName, int $expireTime = 86400);

    /**
     * @param string $lockName
     * @param string $password
     * @return bool
     */
    public static function unLock(string $lockName, string $password): bool;
}