<?php

namespace ZWan\Tool\Common;

interface ProviderInterface
{
    /**
     * @param $handlerService
     * @return mixed
     */
    public static function register($handlerService);


    /**
     * @return mixed
     */
    public static function clear();
}