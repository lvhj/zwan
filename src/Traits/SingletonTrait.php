<?php

namespace ZWan\Traits;

trait SingletonTrait
{
    /**
     * 禁止克隆
     *
     * @return void
     */
    private function __clone()
    {
    }

    /**
     * 禁止反序列化
     *
     * @return void
     */
    private function __wakeup()
    {
    }
}