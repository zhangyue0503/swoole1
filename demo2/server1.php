<?php

class Server
{
    private $serv;

    public function __construct()
    {
        $this->serv = new swoole_server("0.0.0.0", 9501);
        $this->serv->set([
            'worker_num'      => 8,
            'daemonize'       => false,
            'max_request'     => 10000,
            'dispatch_mode'   => 2,
            'task_worker_num' => 8,
        ]);
        $this->serv->on('Start', [$this, 'onStart']);
        $this->serv->on('Connect', [$this, 'onConnect']);
        $this->serv->on('Receive', [$this, 'onReceive']);
        $this->serv->on('Close', [$this, 'onClose']);
        $this->serv->on('Task', [$this, 'onTask']);
        $this->serv->on('Finish', [$this, 'onFinish']);
        $this->serv->start();
    }

    public function onStart($serv)
    {
        echo "Start\n";
    }

    public function onConnect($serv, $fd, $from_id)
    {
        echo "Client {$fd} connect\n";
    }

    public function onClose($serv, $fd, $from_id)
    {
        echo "Client {$fd} close connection\n";
    }

    public function onReceive(swoole_server $serv, $fd, $from_id, $data)
    {
        echo "Get Message From Client {$fd}:{$data}\n";

        // 任务投递
        $data = [
            'task' => 'task_1',
            'params' => $data,
            'fd'   => $fd,
        ];
        $serv->task(json_encode($data));
    }

    public function onTask($serv, $task_id, $from_id, $data)
    {
        echo "This Task {$task_id} from Worker {$from_id}\n";
        echo "Data: {$data}\n";

        $data = json_decode($data, true);

        echo "Receive Task: {$data['task']}\n";
        var_dump($data['params']);

        // 向客户端发送数据
        $serv->send($data['fd'], "Hello Task");
        // 告诉worker完成
        return "Finished";
    }

    public function onFinish($serv, $task_id, $data)
    {
        echo "Task {$task_id} finish\n";
        echo "Result: {$data}\n";
    }
}

$server = new Server();