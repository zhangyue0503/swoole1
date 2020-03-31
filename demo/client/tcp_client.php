<?php
// 连接服务器
$client = new swoole_client(SWOOLE_SOCK_TCP);
if(!$client->connect("127.0.0.1", 9501)){
    echo "连接失败！";
}

// php cli 常量
fwrite(STDOUT, "请输入消息：");
$msg = trim(fgets(STDIN));

// 发送消息给 tcp server
$client->send($msg);

// 接收来自 server 的数据
$result = $client->recv();
echo $result;


