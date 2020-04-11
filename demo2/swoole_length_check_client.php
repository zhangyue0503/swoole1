<?php

class Client
{
    private $client;

    public function __construct()
    {
        $this->client = new swoole_client(SWOOLE_SOCK_TCP);
    }

    public function connect()
    {
        if (!$this->client->connect("127.0.0.1", 9501, 1)) {
            echo "Error : {$this->client->errMsg}[{$this->client->errCode}]";
        }

        $msg_normal = "This is a Msg\r\n";
        $msg_legnth = pack("N", strlen($msg_normal)) . $msg_normal;

        $i = 0;
        while ($i < 100) {
            var_dump("test");
            $this->client->send($msg_legnth);
            $i++;
        }
    }


}

$client = new Client();
$client->connect();