## 使用示例

001 支持批量查询字符串       
002 支持批量查询hash

### 查询多key

```php
<?php
require_once __DIR__ . '/vendor/composer/autoload_real.php';
ComposerAutoloaderInit433553deb3983bcfb6d3ec6a0ff4ef87::getLoader();

try {
    $redis = new \Redis();
    $redis->connect('127.0.0.1', 6379);
    $redis->auth('123456');

    $redis->HMSET('key2', [
        'id' => 1,
        'name' => 'name555',
        'age' => 100,
    ]);

    // 将redis连接注入到redisApplication
    \ZWan\Tool\Applications\RedisApplication::setRedis($redis);

    $queryParam = new \ZWan\Tool\RedisProxy\Params\MultiQueryRedisParam();
    $queryParam->dataType = \ZWan\Tool\RedisProxy\Constants\RedisDataEnum::TYPE_HASH;
    $queryParam->keys = ['key1', 'key2', 'key3'];
    $queryParam->jsonArray = true;

    $values = \ZWan\Tool\RedisProxy\Services\RedisMultiQuery::multiQuery($queryParam);
    dd($values);
} catch (Exception $e) {
    dd($e);
}
```

### 执行多命令

```php
$results = \ZWan\Tool\RedisProxy\Services\RedisPipelineHelper::execute(function ($pipeline) {
        $pipeline->set('key1', 'value111');
        $pipeline->get('key1');
        $pipeline->set('key2', 'value222');
        $pipeline->get('key2');
        $pipeline->setnx('key2', 'value3');
    });
dd($results)
# results 输出值
# [true,"value111",true,"value222",false]
```
