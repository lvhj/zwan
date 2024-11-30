<?php

namespace ZWan\Applications;

use ZWan\Traits\SingletonTrait;

class RedisApplication
{
    use SingletonTrait;

    /**
     * redis实例
     *
     * @var null
     */
    private static $instance = null;

    /**
     * redis实例
     *
     * @var null
     */
    private $redis = null;

    /**
     * RedisApplication constructor.
     * @param $redis
     */
    private function __construct($redis)
    {
        $this->redis = $redis;
    }

    /**
     * 获取唯一的 RedisApplication 实例
     *
     * @return RedisApplication
     */
    public static function getInstance($redis = null)
    {
        if (self::$instance === null) {
            if ($redis === null) {
                throw new MutexExcepti("Redis instance must be provided for the first time.");
            }
            self::$instance = new self($redis);
        }
        return self::$instance;
    }

    /**
     * 获取 Redis 实例
     *
     * @return mixed
     */
    public function getRedis()
    {
        return $this->redis;
    }
}