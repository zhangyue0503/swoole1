<?php

$filename = __DIR__ . '/1.txt';
go(function () use ($filename)
{
    $r = Swoole\Coroutine\System::writeFile($filename, "alksdjflsjdflkj", FILE_APPEND);
    var_dump($r);
});