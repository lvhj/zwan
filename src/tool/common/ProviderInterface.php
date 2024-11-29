<?php

namespace ZWan\Tool\Common;

interface ProviderInterface
{
    public static function register($handlerService);


    public static function clear();
}