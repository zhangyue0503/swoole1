<?php

class Server
{
    private $serv;

    public function __construct()
    {
        $this->serv = new swoole_server("0.0.0.0", 9502);
        $this->serv->set([
            'worker_num'         => 1,
            'daemonize'          => false,
            'max_request'        => 10000,
            'dispath_mode'       => 2,
            'package_max_length' => 8192,
//             'open_eof_check'     => true,
            'open_eof_split'     => true,
            'package_eof'        => "\r\n",
        ]);

        $this->serv->on('Start', [$this, 'onStart']);
        $this->serv->on('Connect', [$this, 'onConnect']);
        $this->serv->on('Receive', [$this, 'onReceive']);
        $this->serv->on('Close', [$this, 'onClose']);

        $this->serv->start();
    }

    public function onStart($serv)
    {
        echo "Start\n";
    }

    public function onConnect($serv, $fd, $form_id)
    {
        echo "Client {$fd} connect\n";
    }

    public function onReceive(swoole_server $serv, $fd, $form_id, $data)
    {
        var_dump($data);
//        $data_list = explode("\r\n", $data);
//        foreach ($data_list as $msg) {
//            if (!empty($msg)) {
//                echo "Get Message From Client {$fd}: {$msg}\n";
//            }
//        }
    }

    public function onClose($serv, $fd, $from_id)
    {
        echo "Client {$fd} close connection\n";
    }

}

new Server();