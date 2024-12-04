<?php

if (!function_exists('dd')) {
    function dd(...$args)
    {
        ddPrint(...$args);
        echo PHP_EOL;
        exit();
    }
}

if (!function_exists('ddd')) {
    function ddd(...$args)
    {
        ddPrint(...$args);
        echo PHP_EOL;
    }
}

if (!function_exists('ddPrint')) {
    function ddPrint(...$args)
    {
        header('Content-type: application/json;charset=utf-8;');
        foreach ($args as $arg) {
            if ($arg instanceof Throwable) {
                header('Content-type: application/xml;charset=utf-8;');
                echo $arg->getMessage() . PHP_EOL;
                echo PHP_EOL;
                echo $arg->getFile() . '(' . $arg->getLine() . ')' . PHP_EOL;
                echo $arg->getTraceAsString() . PHP_EOL;
                exit();
            } elseif (is_array($arg) || is_object($arg)) {
                echo json_encode($arg, 320);
            } else if (is_string($arg) || is_numeric($arg)) {
                echo $arg . PHP_EOL;
            } elseif (is_bool($arg)) {
                $temp = $arg ? "TRUE" : "FALSE";
                echo $temp . PHP_EOL;
            } else if (is_null($arg)) {
                echo 'NULL' . PHP_EOL;
            } else {
                var_dump($arg);
            }
        }
    }
}






