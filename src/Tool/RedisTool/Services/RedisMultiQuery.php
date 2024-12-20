<?php

namespace ZWan\Tool\RedisTool\Services;

use ZWan\Tool\RedisTool\Factory\MultiRedisFactory;
use ZWan\Tool\RedisTool\Params\MultiQueryRedisParam;
use ZWan\Tool\RedisTool\Payload\MultiResultPayload;

class RedisMultiQuery
{
    /**
     * 批量查询redis -支持 string和 hash 数据类型
     *
     * @param MultiQueryRedisParam $multiRedisQueryParam
     * @return MultiResultPayload
     */
    public static function multiQuery(MultiQueryRedisParam $multiRedisQueryParam): MultiResultPayload
    {
        $queryService = MultiRedisFactory::getHandlerService($multiRedisQueryParam->dataType);
        return $queryService->multiQuery($multiRedisQueryParam);
    }
}