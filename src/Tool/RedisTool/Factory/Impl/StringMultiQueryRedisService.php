<?php

namespace ZWan\Tool\RedisTool\Factory\Impl;

use ZWan\Tool\Applications\RedisApplication;
use ZWan\Tool\RedisTool\Factory\MultiQueryRedisInterface;
use ZWan\Tool\RedisTool\Params\MultiQueryRedisParam;
use ZWan\Tool\RedisTool\Payload\MultiResultPayload;

class StringMultiQueryRedisService implements MultiQueryRedisInterface
{
    /**
     * 批量获取redis缓存 只针对值为字符串类型
     *
     * @param MultiQueryRedisParam $multiQueryRedisParam
     * @return MultiResultPayload
     */
    public function multiQuery(MultiQueryRedisParam $multiQueryRedisParam): MultiResultPayload
    {
        $redisApplication = RedisApplication::getRedis();
        $resultList = $redisApplication->mget($multiQueryRedisParam->keys);
        return MultiResultPayload::conversion($multiQueryRedisParam, $resultList);
    }
}