<?php

require_once __DIR__ . '/vendor/autoload.php';

use \Hprose\Future;
use \Hprose\Swoole\Client;

$test = new Client("tcp://0.0.0.0:1314");
$test->fullDuplex = true;
$var_dump = Future\warp("var_dump");

Feture\co(function() use($test){
    try {
        var_dump((yield $test->hello("yield world1")));
        var_dump((yield $test->hello("yield world2")));
        var_dump((yield $test->hello("yield world3")));
        var_dump((yield $test->hello("yield world4")));
        var_dump((yield $test->hello("yield world5")));
        var_dump((yield $test->hello("yield world6")));
    } catch (Exception $e) {
        echo $e;
    }
} );

$var_dump($test->hello("async world1"));
$var_dump($test->hello("async world2"));
$var_dump($test->hello("async world3"));
$var_dump($test->hello("async world4"));
$var_dump($test->hello("async world5"));
$var_dump($test->hello("async world6"));

$test->sum(1, 2)
    ->then(function($result) use($test){
        var_dump($result);
        return $test->sum($result, 1);
    })
    ->then(function($result) use($test){
        var_dump($result);
        return $test->sum($result, 1);
    })
    ->then(function($result) use($test){
        var_dump($result);
        return $test->sum($result, 1);
    })
    ->then(function($result) use($test){
        var_dump($result);
        return $test->sum($result, 1);
    })
    ->then(function($result) use($test){
        var_dump($result);
        return $test->sum($result, 1);
    })
    ->then(function($result){
        var_dump($result);
    });