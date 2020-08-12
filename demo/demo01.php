<?php
require_once __DIR__ . '/common.php';

$senObj = \CjsSensitive\SensitiveWordFilter::getInstance();
//要过滤的内容
$content = <<<EOT
    likeyou小白喜欢小黑爱着的大黄
    <html>红杏出墙 哈哈
    </html>
EOT;

$wordList = ['小明', '小红', '大白', '小白', '小黑', 'me', 'you','红杏出墙'];  //定义敏感词数组
$wordStr = implode("|", $wordList);
$senObj->setSensitiveWordDict($wordStr);
$senObj->setReplaceSymbol("***");
$result = $senObj->sensitive($content);
var_export($result);
echo PHP_EOL;

$log = "匹配到 [ {$result['count']} ]个敏感词：[ {$result['sensitive_word']} ]" . PHP_EOL .
    "替换后为：[ {$result['after']} ]" . PHP_EOL;
echo $log;
