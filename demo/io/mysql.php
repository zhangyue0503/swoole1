<?php

Swoole\Runtime::enableCoroutine(SWOOLE_HOOK_ALL | SWOOLE_HOOK_CURL);

go(function() {
    $pdo = new PDO('mysql:host=localhost;dbname=blog_test;charset=utf8mb4', 'root', '');

    $pre = $pdo->prepare("SELECT id FROM zyblog_test_user ");
//    $pre->bindParam(':username', $username);
    $pre->execute();
    $result = $pre->fetchAll(PDO::FETCH_ASSOC);

    var_dump($result);
});

echo "start";