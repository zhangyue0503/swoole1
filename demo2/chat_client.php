<?php
// 事件循环
// 开启 Event Loop 后，程序内会启动一个线程并一直阻塞在 epoll 的监听上，因此不会退出
// 调用 swoole_event_exit 函数即可关闭事件循环（注意， swoole_server 程序中此函数无效）

$socket = stream_socket_client('tcp://127.0.0.1:9501', $errno, $errstr, 30);

function onRead()
{
    global $socket;
    $buffer = stream_socket_recvfrom($socket, 1024);
    if (!$buffer) {
        echo "Server closed\n";
        swoole_event_del($socket);
    }
    echo "\nRECV: {$buffer}\n";
    fwrite(STDOUT, "Enter Msg:");
}

function onWrite()
{
    global $socket;
    echo "on Write\n";
}

function onInput()
{
    global $socket;
    $msg = trim(fgets(STDIN));
    if ($msg == 'exit') {
        swoole_event_exit();
        exit();
    }
    swoole_event_write($socket, $msg);
    fwrite(STDOUT, "Enter Msg:");
}

swoole_event_add($socket, 'onRead', 'onWrite');

swoole_event_add(STDIN, 'onInput');

fwrite(STDOUT, "Enter Msg:");