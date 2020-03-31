<?php


class Ws
{
    const HOST = "0.0.0.0";
    const PORT = "9502";

    public $ws = null;
    public function __construct()
    {
        $this->ws = new Swoole\WebSocket\Server(self::HOST, self::PORT);

        $this->ws->set([
            'worker_num' => 2,
            'task_worker_num' => 2,
        ]);

        $this->ws->on("open", [$this, "onOpen"]);
        $this->ws->on("message", [$this, "onMessage"]);
        $this->ws->on("close", [$this, "onClose"]);

        $this->ws->on("task", [$this, "onTask"]);
        $this->ws->on("finish", [$this, "onFinish"]);

        $this->ws->start();
    }

    public function onOpen($ws, $request){
        var_dump($request->fd);
    }

    public function onMessage($ws, $frame){
        echo "ser-push-message:{$frame->data}\n";

        // todo 10s
        $data = [
            'task'=>1,
            'fd' => $frame->fd,
        ];
        $ws->task($data);

        $ws->push($frame->fd, "serer-push:" . date('Y-m-d H:i:s'));
    }

    public function onClose($ws, $fd){
        echo "Close {$fd}\n";
    }

    public function onTask($serv, $taskId, $workerId, $data){
        print_r($data);
        sleep(10);
        return [
            'fd'=>$data['fd'],
            'message' => 'ok',
        ];
    }

    public function onFinish($serv, $taskId, $data){
        echo "taskId:{$taskId}\n";
        echo "finish-data-success:{$data['message']}\n";
        $this->ws->push($data['fd'], "finish");
    }


}

new Ws();