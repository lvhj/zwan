<?php

namespace ZWan\Tool\RedisTool\Factory;

use ZWan\Tool\RedisTool\Constants\RedisDataEnum;
use ZWan\Tool\RedisTool\Exceptions\RedisProxyException;
use ZWan\Tool\RedisTool\Factory\Impl\HashMultiQueryRedisService;
use ZWan\Tool\RedisTool\Factory\Impl\StringMultiQueryRedisService;

class MultiRedisFactory
{
    public static $serviceList = [
        RedisDataEnum::TYPE_STRING => StringMultiQueryRedisService::class,
        RedisDataEnum::TYPE_HASH => HashMultiQueryRedisService::class
    ];

    public static function getHandlerService(string $dataType): MultiQueryRedisInterface
    {
        if (empty(self::$serviceList[$dataType])) {
            throw RedisProxyException::MUlTI_QUERY_SERVICE_CAN_NOT_BE_EMPTY();
        }
        return new self::$serviceList[$dataType];
    }
}