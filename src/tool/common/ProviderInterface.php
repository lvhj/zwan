<?php

namespace ZWan\tool\common;

interface ProviderInterface
{
    public static function register($handlerService);


    public static function clear();
}