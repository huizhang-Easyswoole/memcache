<?php
/**
 * @CreateTime:   2021/1/24 12:36 上午
 * @Author:       huizhang  <2788828128@qq.com>
 * @Copyright:    copyright(2020) Easyswoole all rights reserved
 * @Description:  memcache 文本协议客户端单测
 */

namespace Huizhang\Tests;

use Huizhang\Memcache\Config;
use Huizhang\Memcache\Memcache;
use PHPUnit\Framework\TestCase;

class TestMemcache extends TestCase
{

    private function getMemcacheClient()
    {
        $config = new Config();
        $config->setServers(
            [
                ['0.0.0.0', 11211, 3],
                ['0.0.0.0', 11211, 3],
            ]
        );
        return new Memcache($config);
    }

    public function testSet()
    {
        $memcache = $this->getMemcacheClient();
        $res = $memcache->set('test', 1);
        $this->assertEquals(1, $res->getStatus());
    }

    public function testAdd()
    {
        $memcache = $this->getMemcacheClient();
        $res = $memcache->add('test' . time(), 1);
        $this->assertEquals(1, $res->getStatus());
    }

    public function testReplace()
    {
        $memcache = $this->getMemcacheClient();
        $res = $memcache->replace('test' . time(), 1);
        $this->assertEquals(1, $res->getStatus());
    }

    public function testAppend()
    {
        $memcache = $this->getMemcacheClient();
        $res = $memcache->append('test' . time(), 1);
        $this->assertEquals(1, $res->getStatus());
    }

    public function testPrepend()
    {
        $memcache = $this->getMemcacheClient();
        $res = $memcache->prepend('test' . time(), 1);
        $this->assertEquals(1, $res->getStatus());
    }

    public function testGet()
    {
        $memcache = $this->getMemcacheClient();
        $time = time();
        $memcache->set('gettest', $time);
        $res = $memcache->get('gettest');
        $this->assertEquals(['gettest' => $time], $res->getData());
    }

    public function testGets()
    {
        $memcache = $this->getMemcacheClient();
        $time = time();
        $memcache->set('gettest', $time);
        $res = $memcache->get('gettest');
        $this->assertEquals(1, $res->getStatus());
    }

    public function testDelete()
    {
        $memcache = $this->getMemcacheClient();
        $time = time();
        $memcache->set('gettest', $time);
        $res = $memcache->delete('gettest');
        $this->assertEquals(1, $res->getStatus());
    }

    public function testIncr()
    {
        $memcache = $this->getMemcacheClient();
        $time = time();
        $memcache->set($time, 0);
        $res = $memcache->incr($time);
        $this->assertEquals(1, $res->getData());
    }

    public function testDecr()
    {
        $memcache = $this->getMemcacheClient();
        $time = time();
        $memcache->set($time, 1);
        $res = $memcache->decr($time);
        $this->assertEquals(0, $res->getData());
    }

    public function testCas()
    {
        $memcache = $this->getMemcacheClient();
        $time = time();
        $memcache->set($time, 1);
        $res = $memcache->gets($time);
        $casId = $res->getData()[$time]['cas'];
        $memcache->cas($time, 3, $casId);
        $res = $memcache->get($time);
        $this->assertEquals(3, $res->getData()[$time]);
    }

    public function testStats()
    {
        $memcache = $this->getMemcacheClient();
        $res = $memcache->stats();
        $this->assertEquals(1, $res->getStatus());
    }

    public function testStatsItems()
    {
        $memcache = $this->getMemcacheClient();
        $res = $memcache->statsItems();
        $this->assertEquals(1, $res->getStatus());
    }

    public function testSlabs()
    {
        $memcache = $this->getMemcacheClient();
        $res = $memcache->statsSlabs();
        $this->assertEquals(1, $res->getStatus());
    }

    public function testStatsSizes()
    {
        $memcache = $this->getMemcacheClient();
        $res = $memcache->statsSizes();
        $this->assertEquals(1, $res->getStatus());
    }

}
