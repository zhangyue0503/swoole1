<?php

$filename = __DIR__ . '/1.txt';
go(function () use ($filename)
{
    $r = Swoole\Coroutine\System::readFile($filename);
    var_dump($r);
});
