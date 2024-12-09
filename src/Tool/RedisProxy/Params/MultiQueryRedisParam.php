<?php

namespace ZWan\Tool\RedisProxy\Params;

use ZWan\Tool\RedisProxy\Constants\RedisDataEnum;

class MultiQueryRedisParam
{
    /**
     * 数据类型
     *
     * @var $dataType
     */
    public $dataType;

    /**
     * redis key
     *
     * @var
     */
    public $keys;

    /**
     * value 值是否为json
     *
     * @var bool
     */
    public $jsonArray;

    /**
     * @return bool
     */
    public function getJsonArray(): bool
    {
        return $this->dataType == RedisDataEnum::TYPE_STRING ? $this->jsonArray : false;
    }
}