<?php

echo "process-start-time:" . time();

$urls = [
    'http://www.baidu.com',
    'http://www.sina.com.cn',
    'http://www.qq.com',
    'http://www.baidu.com?s=zyblog',
    'http://www.baidu.com?s=ds',
    'http://www.baidu.com?s=imooc',
];

$workers = [];
for ($i = 0; $i < 6; $i++) {
    // 子进程
    $process = new swoole_process(function (swoole_process $worker) use ($i, $urls) {
        // curl
        $content = curlData($urls[$i]);
        echo $content, PHP_EOL;
    }, true);

    $pid = $process->start();
    $workers[$pid] = $process;
}

foreach ($workers as $process) {
    echo $process->read();
}

/**
 * 模拟请求URL内容 1S
 * @param $url
 * @return string
 */
function curlData($url)
{
    // curl
    sleep(1);
    return $url . " success" . PHP_EOL;
}

echo "process-end-time:" . time();