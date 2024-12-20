<?php

namespace ZWan\Tool\RedisTool\Factory\Impl;

use ZWan\Tool\Applications\RedisApplication;
use ZWan\Tool\RedisTool\Factory\MultiQueryRedisInterface;
use ZWan\Tool\RedisTool\Params\MultiQueryRedisParam;
use ZWan\Tool\RedisTool\Payload\MultiResultPayload;

class HashMultiQueryRedisService implements MultiQueryRedisInterface
{
    public function multiQuery(MultiQueryRedisParam $multiQueryRedisParam): MultiResultPayload
    {
        $redisApplication = RedisApplication::getRedis();
        // 使用管道批量获取值
        $pipeline = $redisApplication->multi(\Redis::PIPELINE);
        foreach ($multiQueryRedisParam->keys as $key) {
            $pipeline->hgetall($key); // 添加 GET 命令到管道
        }
        $resultList = $pipeline->exec(); // 执行管道命令
        return MultiResultPayload::conversion($multiQueryRedisParam, $resultList);
    }
}