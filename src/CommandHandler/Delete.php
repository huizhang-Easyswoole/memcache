<?php
/**
 * @CreateTime:   2021/1/23 10:37 下午
 * @Author:       huizhang  <2788828128@qq.com>
 * @Copyright:    copyright(2020) Easyswoole all rights reserved
 * @Description:  delete command handler
 */
namespace Huizhang\Memcache\CommandHandler;

use Huizhang\Memcache\Core\MemcacheResponse;

class Delete extends CommandHandlerAbstract
{

    protected $commandName = 'delete';

    public function handler(...$data): MemcacheResponse
    {

    }
}

