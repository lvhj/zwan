<?php

namespace ZWan\Annotations;

/**
 * @Annotation
 * @Target("METHOD")
 */
class ExceptionMethod
{
    public $method;     // 异常方法名
    public $codeOrText; // 错误码或文本
    public $text;       // 错误信息

    public function __construct(array $values)
    {
        $this->method = $values['method'];
        $this->codeOrText = $values['codeOrText'];
        $this->text = $values['text'];
    }
}
