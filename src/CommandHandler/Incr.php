<?php
/**
 * @CreateTime:   2021/1/23 10:44 下午
 * @Author:       huizhang  <2788828128@qq.com>
 * @Copyright:    copyright(2020) Easyswoole all rights reserved
 * @Description:  incr command handler
 */

namespace Huizhang\Memcache\CommandHandler;

use Huizhang\Memcache\Core\ClientResponse;
use Huizhang\Memcache\Core\Response;

class Incr extends CommandHandlerAbstract
{

    protected $commandName = 'incr';

    public function handler(...$data): Response
    {
        [$key, $value] = $data;
        $command = "{$this->commandName} {$key} {$value}\r\n";
        $client = $this->getClient();
        $response = new Response(Response::STATUS_FAILED);
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
