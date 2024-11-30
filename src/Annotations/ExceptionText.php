<?php

namespace ZWan\Annotations;

/**
 * @Annotation
 * @Target("METHOD")
 */
class ExceptionText
{
    public $text; // 异常描述文本

    public function __construct(array $values)
    {
        $this->text = $values['text'];
    }
}
