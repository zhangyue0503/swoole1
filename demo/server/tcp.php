<?php

//创建Server对象，监听 127.0.0.1:9501端口
$serv = new Swoole\Server("0.0.0.0", 9501);

$serv->set([
    'worker_num' => 8, // worker进程数 cpu 1-4倍
    'max_request' => 10000, // 根据cpu 进程等
]);

//监听连接进入事件
/**
 * $fd 客户端连接的唯一标识
 * $reactor_id 线程id
 */
$serv->on('Connect', function ($serv, $fd, $reactor_id) {
    echo "Client: {$reactor_id} - {$fd} - Connect.\n";
});


//监听数据接收事件
/**
 * $from_id == $reactor_id
 */
$serv->on('Receive', function ($serv, $fd, $from_id, $data) {
    $serv->send($fd, "Server: {$from_id} - {$fd} - ".$data);
});

//监听连接关闭事件
$serv->on('Close', function ($serv, $fd) {
    echo "Client: Close.\n";
});

//启动服务器
$serv->start();