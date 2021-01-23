<?php
/**
 * @CreateTime:   2021/1/23 10:53 下午
 * @Author:       huizhang  <2788828128@qq.com>
 * @Copyright:    copyright(2020) Easyswoole all rights reserved
 * @Description:  decr command handler
 */
namespace Huizhang\Memcache\CommandHandler;

use Huizhang\Memcache\Core\ClientResponse;
use Huizhang\Memcache\Core\MemcacheResponse;

class Decr extends CommandHandlerAbstract
{

    protected $commandName = 'decr';

    public function handler(...$data): MemcacheResponse
    {
        [$key, $value] = $data;
        $command = "{$this->commandName} {$key} {$value}\r\n";
        $client = $this->getClient();
        $response = new MemcacheResponse(MemcacheResponse::STATUS_FAILED);
        if ($client->sendCommand($command)) {
            $recv = $client->recv();
            if ($recv->getStatus() !== ClientResponse::STATUS_OK) {
                $response->setErrMsg($recv->getMsg());
            } else {
                if (is_numeric($recv->getData())) {
                    $response->setStatus(ClientResponse::STATUS_OK);
                    $response->setData($recv->getData());
                } else {
                    $response->setErrMsg($recv->getData());
                }
            }
        } else {
            $response->setErrMsg($command);
        }
        return $response;
    }

}
