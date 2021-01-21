<?php

namespace Huizhang\MemcacheClient\Core;

use Swoole\Coroutine\Client as CoroutineClient;

class Client
{

    private $client;

    public function __construct(string $host, int $port, int $timeout)
    {
        $this->client = new CoroutineClient(SWOOLE_TCP);
        $this->client->set([
            'open_eof_check' => true,
            'package_eof' => "\r\n",
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

    public function recv(): ClientResponse
    {
        $response = new ClientResponse();
        $result = $this->client->recv();
        if (empty($result)) {
            $response->setStatus(ClientResponse::STATUS_TIMEOUT);
            $response->setMsg($this->client->errMsg);
        } else {
            $response->setData(trim($result));
        }
        return $response;
    }

}
