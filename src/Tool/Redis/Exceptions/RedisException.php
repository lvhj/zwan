<?php

namespace ZWan\Tool\Redis\Exceptions;

use ZWan\Exceptions\ZWanException;

/**
 * 项目ID:A01
 * 异常类目ID:002
 * 异常类目ID:001
 *
 * 错误号范围:0xA001001001-0xA001001FFF
 *
 * @exception-text 互斥锁不能为空
 * @method static RedisException MUTEX_PROVIDEDR_CANNOT_BE_EMPTY($codeOrText = 0xA01002001, $text = 'mutex provider cannot be empty')
 */
class RedisException extends ZWanException
{

}