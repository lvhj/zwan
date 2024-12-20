<?php

namespace ZWan\Tool\RedisTool\Services;

use ZWan\Tool\Applications\RedisApplication;

class RedisPipelineHelper
{
    /**
     * 一次性执行多个redis命令
     *
     * @param callable $commandsCallback
     * @return array
     */
    public static function execute(callable $commandsCallback): array
    {
        $pipeline = RedisApplication::getRedis()->multi(\Redis::PIPELINE);
        call_user_func($commandsCallback, $pipeline);
        return $pipeline->exec();
    }
}