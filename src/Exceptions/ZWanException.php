<?php

namespace ZWan\Exceptions;

/**
 * 异常ID:16
 * 错误号范围:0xA26016001-0xA26016FFF
 *
 * @exception-text 订单偏好信息成员信息不存在
 * @method static ZWanException ORDER_PREFERENCE_INFO_NOT_FOUND($codeOrText = 0xA26016001, $text = 'order preference info not exist')

 * @exception-text 用户成员信息数量错误
 * @method static ZWanException USER_PREFERENCE_INFO_COUNT_ERROR($codeOrText = 0xA26016002, $text = 'user preference info count error')
 */
class ZWanException extends \RuntimeException
{

}