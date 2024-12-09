<?php

namespace ZWan\Tool\RedisProxy\Services;

use ZWan\Tool\Applications\RedisApplication;

class RedisMultiCommand
{
    public static function execute(callable $commandsCallback): array
    {
        $redis = RedisApplication::getRedis();
        $pipeline = $redis->multi(\Redis::PIPELINE);
        call_user_func($commandsCallback, $pipeline);
        return $pipeline->exec();
    }
}