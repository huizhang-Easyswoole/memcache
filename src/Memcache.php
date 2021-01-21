<?php
/**
 * @CreateTime:   2021/1/20 11:53 下午
 * @Author:       huizhang  <2788828128@qq.com>
 * @Copyright:    copyright(2020) Easyswoole all rights reserved
 * @Description:  mcq客户端
 */

namespace Huizhang\Memcache;

use Huizhang\Memcache\CommandHandler\Set;

class Memcache
{

    private $config;

    public function __construct(Config $config)
    {
        $this->config = $config;
    }

    public function set(string $key, string $value, int $exptime = 0)
    {
        $setHandler = new Set($this->config);
        return $setHandler->handler($key, $value, $exptime);
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


