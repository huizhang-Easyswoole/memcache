<?php
/**
 * @CreateTime:   2021/1/22 1:10 上午
 * @Author:       huizhang  <2788828128@qq.com>
 * @Copyright:    copyright(2020) Easyswoole all rights reserved
 * @Description:  Command handler abstract
 */

namespace Huizhang\Memcache\CommandHandler;

use Huizhang\Memcache\Config;
use Huizhang\Memcache\Core\Client;
use Huizhang\Memcache\Core\Response;
use Huizhang\Memcache\Exception\Exception;

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
        $services = $this->config->getServers();
        if (count($services) === 0) {
            throw new Exception('Please set services!');
        }
        $service = $services[random_int(0, count($services) - 1)];
        [$host, $port, $timeout] = $service;
        return new Client($host, $port, $timeout);
    }

    abstract public function handler(...$data): Response;

}

