<?php
namespace CjsSensitive;

class Util
{
    //对敏感词处理
    public static function wordHandle($word) {
        $word = preg_replace(['/\//', '/[?]/'], ['\\\/', '\?'], $word);
        return $word;
    }

}
