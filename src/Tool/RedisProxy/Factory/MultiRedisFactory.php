<?php

namespace ZWan\Tool\RedisProxy\Factory;

use ZWan\Tool\RedisProxy\Constants\RedisDataEnum;
use ZWan\Tool\RedisProxy\Exceptions\RedisProxyException;
use ZWan\Tool\RedisProxy\Factory\Impl\StringMultiQueryRedisService;

class MultiRedisFactory
{
    public static $serviceList = [
        RedisDataEnum::TYPE_STRING => StringMultiQueryRedisService::class
    ];

    public static function getHandlerService(string $dataType): MultiQueryRedisInterface
    {
        if (empty(self::$serviceList[$dataType])) {
            throw RedisProxyException::MUlTI_QUERY_SERVICE_CAN_NOT_BE_EMPTY();
        }
        return new self::$serviceList[$dataType];
    }
}