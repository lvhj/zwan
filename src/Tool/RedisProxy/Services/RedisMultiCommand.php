<?php

namespace ZWan\Tool\RedisProxy\Services;

use ZWan\Tool\Applications\RedisApplication;

class RedisMultiCommand
{
    /**
     * 一次性执行多个redis命令
     *
     * @param callable $commandsCallback
     * @return array
     */
    public static function execute(callable $commandsCallback): array
    {
        $redis = RedisApplication::getRedis();
        $pipeline = $redis->multi(\Redis::PIPELINE);
        call_user_func($commandsCallback, $pipeline);
        return $pipeline->exec();
    }
}