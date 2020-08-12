<?php
require_once __DIR__ . '/common.php';

$senObj = \CjsSensitive\SensitiveWordFilter::getInstance();
//要过滤的内容
$content = <<<EOT
    likeyou小白喜欢小黑爱着的大黄
    <html>红杏出墙 哈哈
    卖.逼5毛"""呵呵
    </html>
EOT;

//定义敏感词数组
$wordListTmp = file(__DIR__ . '/word.txt');
$wordList = [];
foreach ($wordListTmp as $v) {
    $v = trim($v);
    if(!$v) {
        continue;
    }
    $wordList[] = \CjsSensitive\Util::wordHandle($v);
}
$wordStr = implode("|", $wordList);
$senObj->setSensitiveWordDict($wordStr)->appendSensitiveWordDict("红杏出墙");
$senObj->setReplaceSymbol("*");
$result = $senObj->sensitive($content);
var_export($result);
echo PHP_EOL;

$log = "匹配到 [ {$result['count']} ]个敏感词：[ {$result['sensitive_word']} ]" . PHP_EOL .
    "替换后为：[ {$result['after']} ]" . PHP_EOL;
echo $log;
