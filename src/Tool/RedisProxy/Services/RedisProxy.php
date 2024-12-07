<?php

namespace ZWan\Tool\RedisProxy\Services;

use ZWan\Tool\Applications\RedisApplication;
use ZWan\Tool\RedisProxy\Factory\MultiRedisFactory;
use ZWan\Tool\RedisProxy\Params\MultiQueryRedisParam;
use ZWan\Tool\RedisProxy\Payload\MultiResultPayload;
use ZWan\Traits\SingletonTrait;

class RedisProxy
{
    use SingletonTrait;

    private static $redisProxy = null;

    private static $redis = null;

    private function __construct()
    {
        self::$redis = RedisApplication::getRedis();
    }

    /**
     * 获取redis代理实例
     *
     * @return RedisProxy
     */
    public static function getRedisProxy(): RedisProxy
    {
        if (self::$redisProxy === null) {
            self::$redisProxy = new self();
        }
        return self::$redisProxy;
    }

    /**
     * @param MultiQueryRedisParam $multiRedisQueryParam
     * @return MultiResultPayload
     */
    public function multiQuery(MultiQueryRedisParam $multiRedisQueryParam): MultiResultPayload
    {
        $queryService = MultiRedisFactory::getHandlerService($multiRedisQueryParam->dataType);
        return $queryService->multiQuery($multiRedisQueryParam);
    }

    /**
     * @throws
     */
    public function __call($method, $args)
    {
        if (method_exists(self::$redis, $method)) {
            return call_user_func_array(array(self::$redis, $method), $args);
        } else {
            throw new \Exception("Can not find method {$method} in redis");
        }
    }
}