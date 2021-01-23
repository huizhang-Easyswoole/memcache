# memcache协程客户端
> 基于文本协议

### 使用方式

````php
<?php

include './vendor/autoload.php';

use Huizhang\Memcache\Memcache;
use Huizhang\Memcache\Config;

go(function () {
    $config = new Config();
    $config->setServers(
        [
            ['0.0.0.0', 11211, 3],
            ['0.0.0.0', 11211, 3],
        ]
    );
    $client = new Memcache($config);
    $client->set('test1', 123);
    $client->set('test2', 123);
    $client->add('test3', 123);
    $client->replace('test1', 123);
    $client->append('test1', 666, 3);
    $client->cas('test1', 666, 1, 3);
    $client->get('test1', 'test2', 'test3');
    $client->gets('test1', 'test2', 'test3');
    $client->delete('test1');
    $client->incr('test1');
    $client->decr('test1');
    $client->stats();
    $client->stats();
    $client->statsSlabs();
    $client->statsSizes();
    $client->statsItems();
    $client->flushAll();
});

````
