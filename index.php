<?php

require_once __DIR__ . '/vendor/composer/autoload_real.php';
ComposerAutoloaderInit433553deb3983bcfb6d3ec6a0ff4ef87::getLoader();

try {
    $redis = new \Redis();
    $redis->connect('127.0.0.1', 6379);
    $redis->auth('123456');
    \ZWan\Tool\Applications\RedisApplication::setRedis($redis); // 将redis连接注入到redisApplication
} catch (Exception $e) {
    dd(1, $e->getCode());
}

