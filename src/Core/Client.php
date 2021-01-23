<?php

namespace Huizhang\Memcache\Core;

use Huizhang\Memcache\Exception\Exception;
use Swoole\Coroutine\Client as CoroutineClient;

class Client
{

    private $host;
    private $port;
    private $timeout;

    private $clients = [];

    public function __construct(string $host, int $port, int $timeout)
    {
        $this->host = $host;
        $this->port = $port;
        $this->timeout = $timeout;
    }

    private function getConnect(): CoroutineClient
    {
        $connectStr = "{$this->host}:{$this->port}:{$this->timeout}";
        $key = md5($connectStr);
        if (!(isset($this->clients[$key]) && $this->clients[$key]->isConnected())) {
            $this->client = new CoroutineClient(SWOOLE_TCP);
            $this->client->set([
                'open_eof_check' => true,
                'package_eof' => "\r\n",
                'package_max_length' => 1024 * 1024 * 2
            ]);
            if (!$this->client->connect($this->host, $this->port, $this->timeout)) {
                throw new Exception("Connect to Memcache {$connectStr} failed: {$this->client->errMsg}");
            }
            $this->clients[$key] = $this->client;
        }
        return $this->clients[$key];
    }

    public function sendCommand(string $command)
    {
        $connect = $this->getConnect();
        $res = $connect->send($command);
        return strlen($command) === $res;
    }

    public function recv(): ClientResponse
    {
        $connect = $this->getConnect();
        $response = new ClientResponse();
        $result = $connect->recv();
        if (empty($result)) {
            $response->setStatus(ClientResponse::STATUS_TIMEOUT);
            $response->setMsg($connect->errMsg);
        } else {
            $response->setData(trim($result));
        }
        return $response;
    }

}
