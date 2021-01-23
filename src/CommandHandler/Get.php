<?php
/**
 * @CreateTime:   2021/1/23 9:57 下午
 * @Author:       huizhang  <2788828128@qq.com>
 * @Copyright:    copyright(2020) Easyswoole all rights reserved
 * @Description:  get command handler
 */

namespace Huizhang\Memcache\CommandHandler;

use Huizhang\Memcache\Core\ClientResponse;
use Huizhang\Memcache\Core\MemcacheResponse;

class Get extends CommandHandlerAbstract
{

    protected $commandName = 'get';

    public function handler(...$data): MemcacheResponse
    {
        $command = [$this->commandName];
        foreach ($data as $key) {
            $command[] = $key;
        }
        $command = implode(' ', $command) . "\r\n";
        $client = $this->getClient();
        $response = new MemcacheResponse(MemcacheResponse::STATUS_FAILED);
        if ($client->sendCommand($command)) {
            $result = [];
            $key = null;
            while (true) {
                $recv = $client->recv();
                if ($recv->getStatus() !== ClientResponse::STATUS_OK) {
                    $response->setErrMsg($recv->getMsg());
                    break;
                }
                if ($recv->getData() === 'END') {
                    break;
                }
                $data = $recv->getData();
                $dataArr = explode(' ', $data);
                if (count($dataArr) === 4) {
                    $key = $dataArr[1];
                } else {
                    $result[$key] = $data;
                }
            }
            $response->setStatus(MemcacheResponse::STATUS_SUCCESS);
            $response->setData($result);
        } else {
            $response->setErrMsg($command);
        }
        return $response;
    }

}
