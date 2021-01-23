<?php
/**
 * @CreateTime:   2021/1/23 11:02 下午
 * @Author:       huizhang  <2788828128@qq.com>
 * @Copyright:    copyright(2020) Easyswoole all rights reserved
 * @Description:  stats slabs command handler
 */

namespace Huizhang\Memcache\CommandHandler;

use Huizhang\Memcache\Core\ClientResponse;
use Huizhang\Memcache\Core\MemcacheResponse;

class StatsSlabs extends CommandHandlerAbstract
{

    protected $commandName = 'stats slabs';

    public function handler(...$data): MemcacheResponse
    {
        $command = "{$this->commandName}\r\n";
        $client = $this->getClient();
        $response = new MemcacheResponse(MemcacheResponse::STATUS_FAILED);
        if ($client->sendCommand($command)) {
            $result = [];
            while (true) {
                $recv = $client->recv();
                if ($recv->getData() === 'END') {
                    $response->setStatus(MemcacheResponse::STATUS_SUCCESS);
                    $response->setData($result);
                    break;
                }
                if ($recv->getStatus() !== ClientResponse::STATUS_OK) {
                    $response->setErrMsg($recv->getMsg());
                    break;
                }
                $data = $recv->getData();
                $dataArr = explode(' ', $data);
                $result[$dataArr[1]] = $dataArr[2];
            }
        } else {
            $response->setErrMsg($command);
        }
        return $response;
    }

}
