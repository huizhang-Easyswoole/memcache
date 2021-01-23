<?php
/**
 * @CreateTime:   2021/1/23 11:17 下午
 * @Author:       huizhang  <2788828128@qq.com>
 * @Copyright:    copyright(2020) Easyswoole all rights reserved
 * @Description:  flush_all command handler
 */

namespace Huizhang\Memcache\CommandHandler;

use Huizhang\Memcache\Core\ClientResponse;
use Huizhang\Memcache\Core\Response;

class FlushAll extends CommandHandlerAbstract
{

    protected $commandName = 'flush_all';

    public function handler(...$data): Response
    {
        [$time] = $data;
        if (is_numeric($time)) {
            $time = ' ' . $time;
        } else {
            $time = '';
        }
        $command = sprintf("%s%s\r\n", $this->commandName, $time);
        $client = $this->getClient();
        $response = new Response(Response::STATUS_FAILED);
        if ($client->sendCommand($command)) {
            $recv = $client->recv();
            if ($recv->getStatus() !== ClientResponse::STATUS_OK) {
                $response->setErrMsg($recv->getMsg());
            } else {
                if ($recv->getData() === 'OK') {
                    $response->setStatus(ClientResponse::STATUS_OK);
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

