<?php

namespace ZWan\Tool\Mutex\Exceptions;

use App\Domain\Order\Exception\OrderException;
use ZWan\Exceptions\ZWanException;

/**
 * 项目ID:A01
 * 异常类目ID:001
 * 异常类目ID:01
 *
 * 错误号范围:0xA001001001-0xA001001FFF
 *
 * @exception-text 互斥锁不能为空
 * @method static MutexException MUTEX_PROVIDEDR_CANNOT_BE_EMPTY($codeOrText = 0xA01001001, $text = 'mutex provider cannot be empty')
 *
 * @exception-text 尝试解锁已解锁的互斥锁
 * @method static MutexException TRY_TO_UNLOCK_OF_UNLOCKED_MUTEX($codeOrText = 0xA01001002, $text = 'try to unlock of unlocked Mutex')
 *
 * @exception-text 尝试解锁已过期的互斥锁
 * @method static MutexException TRY_TO_UNLOCK_OF_EXPIRED_MUTEX($codeOrText = 0xA01001003, $text = 'try to unlock of expired Mutex')
 *
 * @exception-text 互斥锁不能为空
 * @method static MutexException MUTEX_PROVIDEDR_HAS_BEEN_REGISTERED($codeOrText = 0xA01001001, $text = 'mutex provider has been registered')
 */
class MutexException extends ZWanException
{
}