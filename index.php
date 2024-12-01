<?php

require_once __DIR__ . '/vendor/composer/autoload_real.php';
ComposerAutoloaderInit5b16528999c1beb466aaefe9037c5b65::getLoader();

try {
    throw \ZWan\Tool\Redis\Exceptions\RedisException::MUTEX_PROVIDEDR_CANNOT_BE_EMPTY();
} catch (Exception $e) {
    dd($e);
}

