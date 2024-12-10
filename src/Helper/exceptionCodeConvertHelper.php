<?php

// zwan 错误码 转化为 十进制
if (!function_exists('zwan_hex_convert_code')) {
    function zwan_hex_convert_code(string $exceptionCode)
    {
        return intval(substr($exceptionCode, 2), 16);
    }
}

// zwan 十进制 转化为 错误码
if (!function_exists('zwan_code_convert_hex')) {
    function zwan_code_convert_hex($exceptionCodeNumber): string
    {
        return '0x' . sprintf('%X', $exceptionCodeNumber);
    }
}
