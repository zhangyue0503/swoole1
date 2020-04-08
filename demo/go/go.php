<?php
Swoole\Runtime::enableCoroutine();
//Co\run(function(){
    for ($i = 0; $i < 6; $i++) {
        Swoole\Coroutine\run(function () use ($i) {
            sleep(rand(1, 5));
            echo $i, PHP_EOL;
        });
    }
//});


//\Co\run(function() {
//    for ($i = 0; $i < 6; $i++) {
//        go(function () use ($i) {
//            sleep(rand(1, 5));
//            echo $i, PHP_EOL;
//        });
//    }
//
//    for ($i = 0; $i < 6; $i++) {
//        go(function () use ($i) {
//            sleep(rand(1, 5));
//            echo "n:", $i, PHP_EOL;
//        });
//    }
//});
//\Co\run(function() {
////    for ($i = 0; $i < 6; $i++) {
//        go(function () {
//            for ($i = 0; $i < 6; $i++) {
//                sleep(rand(1, 5));
//                echo $i, PHP_EOL;
//            }
//
//        });
////    }
//});
