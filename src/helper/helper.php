<?php

if (!function_exists('dd')) {
    function dd(...$args)
    {
        ddPrint(...$args);
        exit();
    }
}

if (!function_exists('ddd')) {
    function ddd(...$args)
    {
        ddPrint(...$args);
    }
}

if (!function_exists('ddPrint')) {
    function ddPrint(...$args)
    {
        header('Content-type: application/json;charset=utf-8;');
        foreach ($args as $arg) {
            if ($arg instanceof Throwable) {
                echo $arg->getMessage() . PHP_EOL;
                echo $arg->getFile() . PHP_EOL;
                echo $arg->getLine() . PHP_EOL;
                echo $arg->getTraceAsString() . PHP_EOL;
            } elseif (is_array($arg) || is_object($arg)) {
                echo json_encode($arg, 320);
            } else if (is_string($arg) || is_numeric($arg)) {
                echo $arg;
            } elseif (is_bool($arg)) {
                var_dump($arg);
            } else if (is_null($arg)) {
                echo 'NULL';
            } else {
                var_dump($arg);
            }
            echo PHP_EOL;
        }
    }
}






