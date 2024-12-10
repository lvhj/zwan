<?php

namespace ZWan\Tool\Mutex\Exceptions;

use App\Domain\Order\Exception\OrderException;
use ZWan\Exceptions\ZWanException;

/**
 * 项目ID:A01
 * 异常类目ID:001
 *
 * 错误号范围:0xA01001001-0xA01001FFF
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
 * @exception-text 互斥锁已经被注册
 * @method static MutexException MUTEX_PROVIDEDR_HAS_BEEN_REGISTERED($codeOrText = 0xA01001004, $text = 'mutex provider has been registered')
 *
 * @exception-text 添加互斥锁失败
 * @method static MutexException MUTEX_LOCK_HAS_LOCKED($codeOrText = 0xA01001005, $text = 'lock fail, try it later')
 */
class MutexException extends ZWanException
{
    /**
     * 独占锁抢用失败 - 0xA01001005
     */
    const LOCK_FAIL_EXCEPTION_CODE = 42966454277;//十进制
}