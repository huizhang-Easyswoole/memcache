<?php
/**
 * @CreateTime:   2021/1/20 11:53 下午
 * @Author:       huizhang  <2788828128@qq.com>
 * @Copyright:    copyright(2020) Easyswoole all rights reserved
 * @Description:  mcq客户端
 */

namespace Huizhang\MemcacheClient;

class MemcacheClient
{

    private $config;

    public function __construct(Config $config)
    {
        $this->config = $config;
    }

    public function set(string $key, string $value, int $exptime = 0)
    {
        $tcpClient = $this->getTcpClient();
        $bytes = strlen($value);
        $command = "set {$key} 0 {$exptime} {$bytes} \r\n";
        if ($tcpClient->sendCommand($command)) {
            $res = $tcpClient->sendCommand("888\r\n");
            if ($res) {
                $tcpClient->recv();
            }
        }
    }

    private function getTcpClient()
    {
        return new TcpClient(
            $this->config->getHost()
            , $this->config->getPort()
            , $this->config->getTimeout()
        );
    }

    public function add()
    {

    }

    public function replace()
    {

    }

    public function prepend()
    {

    }

    public function get()
    {

    }

    public function gets()
    {

    }

    public function delete()
    {

    }

    public function incr()
    {

    }

    public function decr()
    {

    }

    public function stats()
    {

    }

    public function statsItems()
    {

    }

    public function statsSlabs()
    {

    }

    public function statsSizes()
    {

    }

    public function flushAll()
    {

    }

}


