<?php

namespace ZWan\Tool\Applications\Exceptions;

use ZWan\Exceptions\ZWanException;

/**
 * 项目ID:A01
 * 异常类目ID:003
 *
 * 错误号范围:0xA01001001-0xA01001FFF
 *
 * @exception-text redis连接已经存在
 * @method static ApplicationException REDIS_APPLICATION_HAS_EXISTED($codeOrText = 0xA01003001, $text = 'redis application has existed')
 *
 * @exception-text redis连接不存在
 * @method static ApplicationException REDIS_APPLICATION_IS_NOT_EXISTED($codeOrText = 0xA01003001, $text = 'redis application is not existed')
 */
class ApplicationException extends ZWanException
{

}