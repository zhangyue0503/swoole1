<?php
require_once __DIR__ . "/vendor/autoload.php";

use Hprose\Rpc\Server;

function hello($name)
{
    return "Hello {$name}!";
}

class Controller
{
    public function sum($a, $b)
    {
        if (!is_int($a)) {
            return null;
        }
        if (!is_int($b)) {
            return null;
        }
        return $a + $b;
    }
}

$server = new Server('tcp://0.0.0.0:1314');
$server->setErrorTypes(E_ALL);
$server->setDebugEnabled();
$server->addFunction('hello');
$server->add(new Controller());
$server->start();