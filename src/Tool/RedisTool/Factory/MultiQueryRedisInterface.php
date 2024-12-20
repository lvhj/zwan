<?php

namespace ZWan\Tool\RedisTool\Factory;

use ZWan\Tool\RedisTool\Params\MultiQueryRedisParam;
use ZWan\Tool\RedisTool\Payload\MultiResultPayload;

interface MultiQueryRedisInterface
{
    public function multiQuery(MultiQueryRedisParam $multiQueryRedisParam): MultiResultPayload;
}