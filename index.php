<?php

require_once __DIR__ . '/vendor/composer/autoload_real.php';
ComposerAutoloaderInit433553deb3983bcfb6d3ec6a0ff4ef87::getLoader();

try {
    $redis = new \Redis();
    $redis->connect('127.0.0.1', 6379);
    $redis->auth('123456');

    $redis->set('key2', json_encode([
        'id' => 1,
        'name' => 'name555'
    ]), 10000);

    // 将redis连接注入到redisApplication
    \ZWan\Tool\Applications\RedisApplication::setRedis($redis);

    $queryParam = new \ZWan\Tool\RedisProxy\Params\MultiQueryRedisParam();
    $queryParam->dataType = \ZWan\Tool\RedisProxy\Constants\RedisDataEnum::TYPE_STRING;
    $queryParam->keys = ['key1', 'key2', 'key4'];
    $queryParam->jsonArray = true;

    $redisProxy = \ZWan\Tool\RedisProxy\Services\RedisProxy::getRedisProxy();
    $values = $redisProxy->multiQuery($queryParam);
    dd($values, 23);
} catch (Exception $e) {
    dd(123, $e);
}

