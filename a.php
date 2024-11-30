<?php

require_once __DIR__ . '/vendor/composer/autoload_real.php';
ComposerAutoloaderInit5b16528999c1beb466aaefe9037c5b65::getLoader();
ddd(123);
try {
    throw \ZWan\Exceptions\ZWanException::ORDER_PREFERENCE_INFO_NOT_FOUND();
} catch (Exception $exception) {
    dd($exception->getMessage(), $exception->getCode());
}