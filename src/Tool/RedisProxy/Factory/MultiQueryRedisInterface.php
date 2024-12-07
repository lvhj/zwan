<?php

namespace ZWan\Tool\RedisProxy\Factory;

use ZWan\Tool\RedisProxy\Params\MultiQueryRedisParam;
use ZWan\Tool\RedisProxy\Payload\MultiResultPayload;

interface MultiQueryRedisInterface
{
    public function multiQuery(MultiQueryRedisParam $multiQueryRedisParam): MultiResultPayload;
}