## 使用示例

### 查询多key

```php
<?php

require_once __DIR__ . '/vendor/composer/autoload_real.php';
ComposerAutoloaderInit433553deb3983bcfb6d3ec6a0ff4ef87::getLoader();

try {
    $redis = new \Redis();
    $redis->connect('127.0.0.1', 6379);
    $redis->auth('123456');

    \ZWan\Tool\Applications\RedisApplication::setRedis($redis);
    $redisProxy = \ZWan\Tool\RedisProxy\Services\RedisProxy::getRedisProxy();

    $redisProxy->set('key1', json_encode([
        'id' => 1,
        'name' => 'name555'
    ]), 10000);

    $queryParam = new \ZWan\Tool\RedisProxy\Params\MultiQueryRedisParam();
    $queryParam->dataType = \ZWan\Tool\RedisProxy\Constants\RedisDataEnum::TYPE_STRING;
    $queryParam->keys = ['key1', 'key2', 'key4'];
    $queryParam->jsonArray = true;
    $values = $redisProxy->multiQuery($queryParam);
    dd($values, 23);
} catch (Exception $e) {
    dd(123, $e);
}
```



