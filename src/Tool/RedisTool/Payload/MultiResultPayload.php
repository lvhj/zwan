<?php

namespace ZWan\Tool\RedisTool\Payload;

use ZWan\Tool\RedisTool\Params\MultiQueryRedisParam;

class MultiResultPayload
{
    /**
     * 查询结果
     *
     * @var array[][]
     */
    public $result;

    /**
     * 不存在的keys
     *
     * @var array
     */
    public $nonExistentKeys;

    /**
     * @param MultiQueryRedisParam $multiRedisQueryParam
     * @param array $resultList
     * @return MultiResultPayload
     */
    public static function conversion(MultiQueryRedisParam $multiRedisQueryParam, array $resultList): MultiResultPayload
    {
        $payload = new self();
        array_walk($multiRedisQueryParam->keys,
            function ($key, $index) use ($resultList, &$payload, $multiRedisQueryParam) {
                $result = $resultList[$index];
                if ($result === false || (is_array($result) && empty($result))) {
                    $payload->nonExistentKeys[] = $key;
                } else {
                    $payload->result[$key] = $multiRedisQueryParam->getJsonArray() ? json_decode($result, 320) : $result;
                }
            });
        return $payload;
    }
}