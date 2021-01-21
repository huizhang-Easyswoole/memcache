<?php
/**
 * @CreateTime:   2021/1/22 1:32 上午
 * @Author:       huizhang  <2788828128@qq.com>
 * @Copyright:    copyright(2020) Easyswoole all rights reserved
 * @Description:  cas handler
 */

namespace Huizhang\Memcache\CommandHandler;

use Huizhang\Memcache\Core\ClientResponse;
use Huizhang\Memcache\Core\MemcacheResponse;

class Cas extends CommandHandlerAbstract
{

    protected $commandName = 'cas';

    public function handler(...$data): MemcacheResponse
    {
        [$key, $value, $token, $expire] = $data;
        $command = sprintf(
            "%s %s 0 %s %s %s\r\n"
            , $this->commandName
            , $key
            , $expire
            , strlen($value)
            , $token
        );
        $client = $this->getClient();
        $response = new MemcacheResponse(MemcacheResponse::STATUS_FAILED);
        if ($client->sendCommand($command)) {
            $command = sprintf("%s\r\n", $value);
            if ($client->sendCommand($command)) {
                $result = $client->recv();
                if ($result->getStatus() === ClientResponse::STATUS_OK) {
                    if ($result->getData() === 'STORED') {
                        $response->setStatus(MemcacheResponse::STATUS_SUCCESS);
                    } else {
                        $response->setErrMsg($result->getData());
                    }
                } else {
                    $response->setErrMsg($result->getMsg());
                }
            } else {
                $response->setErrMsg($command);
            }
        } else {
            $response->setErrMsg($command);
        }
        return $response;
    }

}
