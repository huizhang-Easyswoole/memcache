<?php

namespace Huizhang\Memcache\CommandHandler;

use Huizhang\Memcache\Config;
use Huizhang\Memcache\Core\Client;
use Huizhang\Memcache\Core\MemcacheResponse;

abstract class CommandHandlerAbstract
{

    protected $commandName;
    protected $config;

    public function __construct(Config $config)
    {
        $this->config = $config;
    }

    protected function getClient()
    {
        return new Client(
            $this->config->getHost()
            , $this->config->getPort()
            , $this->config->getTimeout()
        );
    }

    abstract public function handler(...$data): MemcacheResponse;

}

