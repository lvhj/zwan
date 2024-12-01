<?php

use ZWan\Tool\Redis\RedisProxy;

require_once __DIR__ . '/vendor/composer/autoload_real.php';
ComposerAutoloaderInit5b16528999c1beb466aaefe9037c5b65::getLoader();

try {
    $redis = new \Redis();
    $redis->connect('127.0.0.1', 6379);
    $redis->auth('123456');

    $redisProxy = new RedisProxy($redis);

    $redis->set('key1', json_encode([
        'id' => 1,
        'name' => 'name1111'
    ]), array('nx', 'ex' => 1000));

    // MGET 获取多个键的值
    $keys = ['key1', 'key2', 'key4'];
    $values = $redisProxy->mGet($keys);

    $list = [];
    foreach ($keys as $key => $value) {
        if ($values[$key] === false) {
            $queryIds[] = $value;
        } else {
            $cacheList[$key] = json_decode($values[$key], true);
        }
    }

    $dbList = getCallable($queryIds)();
    return array_merge($cacheList, $dbList);
} catch (Exception $e) {
    dd($e);
}

function getCallable($playletIds): callable
{
    return function () use ($playletIds) {
        return getPlayletList($playletIds);
    };
}

function getPlayletList($playletIds): array
{
    $playletList = [
        [
            'id' => 'key1',
            'name' => 'name1'
        ],
        [
            'id' => 'key2',
            'name' => 'name2'
        ],
        [
            'id' => 'key3',
            'name' => 'name3'
        ],
        [
            'id' => 'key4',
            'name' => 'name4'
        ]
    ];
    $playletMap = array_column($playletList, null, 'id');

    return array_map(function ($playletId) use ($playletMap) {
        return $playletMap[$playletId] ?? [];
    }, $playletIds);
}



