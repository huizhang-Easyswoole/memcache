<?php

namespace Huizhang\MemcacheClient;

use EasySwoole\Component\Singleton;

class Config
{

    use Singleton;

    protected $host = '127.0.0.1';
    protected $port = '11211';
    protected $timeout = 3;

    public function getHost()
    {
        return $this->host;
    }

    public function setHost($host)
    {
        $this->host = $host;
        return $this;
    }

    public function getPort()
    {
        return $this->port;
    }

    public function setPort($port): void
    {
        $this->port = $port;
    }

    public function getTimeout()
    {
        return $this->timeout;
    }

    public function setTimeout($timeout): void
    {
        $this->timeout = $timeout;
    }

}
