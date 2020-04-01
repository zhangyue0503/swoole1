<?php

swoole_timer_tick('500', function ($timer_id) {
    static $i = 0;
    $i++;
    echo $i, ',';
    if ($i > 10) {
        swoole_timer_clear($timer_id);
    }
});

swoole_timer_after(2000, function () {
    echo 'after', ',';
});