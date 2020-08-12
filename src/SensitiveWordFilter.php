<?php
namespace CjsSensitive;

class SensitiveWordFilter
{
    protected $sensitiveWordDict = ""; //敏感词字典，用|分隔
    protected $separator = '|'; //敏感词分隔符
    protected $replace_symbol = '*'; //替换符

    public static function getInstance() {
        return new static();
    }

    public function getSeparator()
    {
        return $this->separator;
    }

    public function setSeparator($separator)
    {
        if(!$separator) {
            return $this;
        }
        $this->separator = $separator;
        return $this;
    }

    public function getReplaceSymbol()
    {
        return $this->replace_symbol;
    }

    public function setReplaceSymbol($replace_symbol)
    {
        $this->replace_symbol = $replace_symbol;
    }

    public function setSensitiveWordDict($dict) {
        $this->sensitiveWordDict = trim($dict);
        return $this;
    }

    //追加敏感词
    public function appendSensitiveWordDict($dict) {
        $dict = trim($dict);
        if(!$dict) {
            return $this;
        }
        $this->sensitiveWordDict = $this->sensitiveWordDict . $this->separator . $dict;
        return $this;
    }

    public function getSensitiveWordDict() {
        return $this->sensitiveWordDict;
    }

    public function getSensitiveWordDict2Array() {
        return explode($this->separator, $this->sensitiveWordDict);
    }

    public function sensitive($source_content){
        $ret = [
                'count'=>0,//违规词的个数
                'after'=>$source_content, //替换后的内容
                'sensitive_word'=>'', //敏感词
        ];
        //$ret['after'] = $source_content;
        $sensitiveWordDict = $this->sensitiveWordDict;
        if(!$sensitiveWordDict) {
            return $ret;
        }
        $pattern = "/". $sensitiveWordDict ."/i"; //正则表达式
        //echo $pattern;exit;
        if(preg_match_all($pattern, $source_content, $matches)){ //匹配到了结果
            $patternList = $matches[0];//匹配到的敏感词数组
            $ret['count'] = count($patternList);
            //把匹配到的敏感词数组转字符串
            $ret['sensitive_word'] = implode($this->getSeparator(), $patternList);
            //把匹配到的数组进行合并，替换使用
            $replaceArray = array_combine($patternList, array_fill(0, $ret['count'], $this->getReplaceSymbol()));
            $ret['after'] = strtr($source_content, $replaceArray); //结果替换
        }
        return $ret;
    }

}