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
        $cliModel = php_sapi_name() === 'cli';
        !$cliModel && header('Content-type: application/json;charset=utf-8;');

        foreach ($args as $arg) {
            if ($arg instanceof Throwable) {
                !$cliModel && header('Content-type: application/xml;charset=utf-8;');
                echo PHP_EOL;
                echo $arg->getMessage() . PHP_EOL;
                echo $arg->getFile() . '(' . $arg->getLine() . ')' . PHP_EOL;
                echo $arg->getTraceAsString();
            } elseif (is_array($arg) || is_object($arg)) {
                echo json_encode($arg, 320);
            } else if (is_string($arg) || is_numeric($arg)) {
                echo $arg;
            } elseif (is_bool($arg)) {
                echo $arg ? "true" : "false";
            } else if (is_null($arg)) {
                echo 'NULL';
            } else {
                var_dump($arg);
            }
            echo PHP_EOL;
        }
    }
}






