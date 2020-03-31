<?php

$http = new swoole_http_server("0.0.0.0", 9503);

$http->set([
    'enable_static_handler' => true,
    'document_root' => '/data/www/demo/static',
]);
$http->on('request', function ($request, $response) {
//    print_r($request->get);

    $response->cookie("zyblog", "xsss");
    $response->end("<h1>HTTPServer</h1>" . json_encode($request->get));
});

$http->start();