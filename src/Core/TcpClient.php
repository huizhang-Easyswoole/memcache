<?php
namespace Huizhang\MemcacheClient;

use Swoole\Coroutine\Client;

class TcpClient
{

    private $client;

    public function __construct(string $host, int $port, int $timeout)
    {
        $this->client = new Client(SWOOLE_TCP);
        $this->client->set([
            'open_eof_check'     => true,
            'package_eof'        => "\r\n",
            'package_max_length' => 1024 * 1024 * 2
        ]);
        $this->client->connect($host, $port, $timeout);
    }

    public function sendCommand(string $command)
    {
        var_dump($command);
        $res = $this->client->send($command);
        return strlen($command) === $res;
    }

    public function recv()
    {
        $res = $this->client->recv();
        var_dump($res);
    }

}
