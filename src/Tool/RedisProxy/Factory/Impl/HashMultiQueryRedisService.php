<?php

namespace ZWan\Tool\RedisProxy\Factory\Impl;

use ZWan\Tool\Applications\RedisApplication;
use ZWan\Tool\RedisProxy\Factory\MultiQueryRedisInterface;
use ZWan\Tool\RedisProxy\Params\MultiQueryRedisParam;
use ZWan\Tool\RedisProxy\Payload\MultiResultPayload;

class HashMultiQueryRedisService implements MultiQueryRedisInterface
{
    private static $redis;

    public function multiQuery(MultiQueryRedisParam $multiQueryRedisParam): MultiResultPayload
    {
        $redisApplication = RedisApplication::getRedis();
        // 使用管道批量获取值
        $pipeline = self::$redisApplication->multi(\Redis::PIPELINE);
        foreach ($multiQueryRedisParam->keys as $key) {
            $pipeline->HMGET($key); // 添加 GET 命令到管道
        }
        $resultList = $pipeline->exec(); // 执行管道命令
        return MultiResultPayload::conversion($multiQueryRedisParam, $resultList);
    }
}