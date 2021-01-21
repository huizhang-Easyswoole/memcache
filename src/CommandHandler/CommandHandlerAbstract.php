<?php

namespace Huizhang\MemcacheClient\CommandHandler;

use Huizhang\MemcacheClient\Config;
use Huizhang\MemcacheClient\Core\Client;

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

    abstract public function handler(...$value);

}

