<?php
/**
 * @CreateTime:   2021/1/22 1:15 上午
 * @Author:       huizhang  <2788828128@qq.com>
 * @Copyright:    copyright(2020) Easyswoole all rights reserved
 * @Description:  append handler
 */

namespace Huizhang\Memcache\CommandHandler;

use Huizhang\Memcache\Core\ClientResponse;
use Huizhang\Memcache\Core\Response;

class Append extends CommandHandlerAbstract
{

    protected $commandName = 'append';

    public function handler(...$data): Response
    {
        [$key, $value, $expire] = $data;
        $command = sprintf(
            "%s %s 0 %s %s \r\n"
            , $this->commandName
            , $key
            , $expire
            , strlen($value)
        );
        $client = $this->getClient();
        $response = new Response(Response::STATUS_FAILED);
        if ($client->sendCommand($command)) {
            $command = sprintf("%s\r\n", $value);
            if ($client->sendCommand($command)) {
                $result = $client->recv();
                if ($result->getStatus() === ClientResponse::STATUS_OK) {
                    if ($result->getData() === 'STORED') {
                        $response->setStatus(Response::STATUS_SUCCESS);
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

