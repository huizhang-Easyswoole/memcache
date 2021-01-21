<?php

namespace Huizhang\Memcache;

use EasySwoole\Component\Singleton;

class Config
{

    use Singleton;

    private $host = '127.0.0.1';
    private $port = '11211';
    private $timeout = 3;

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
