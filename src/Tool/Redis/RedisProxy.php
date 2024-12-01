<?php

namespace ZWan\Tool\Redis;

class RedisProxy
{

    private $redis;

    public function __construct($redis)
    {
        // 延迟创建RealSubject对象
        $this->redis = $redis;
    }

    public function __call($method, $args)
    {
        if (method_exists($this->redis, $method)) {
            return call_user_func_array(array($this->redis, $method), $args);
        } else {
            throw new \Exception("Can not find method {$method} in redis");
        }
    }
}