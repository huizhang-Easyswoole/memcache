<?php
/**
 * @CreateTime:   2021/1/23 11:05 下午
 * @Author:       huizhang  <2788828128@qq.com>
 * @Copyright:    copyright(2020) Easyswoole all rights reserved
 * @Description:  stats sizes command handler
 */

namespace Huizhang\Memcache\CommandHandler;

use Huizhang\Memcache\Core\ClientResponse;
use Huizhang\Memcache\Core\Response;

class StatsSizes extends CommandHandlerAbstract
{

    protected $commandName = 'stats sizes';

    public function handler(...$data): Response
    {
        $command = "{$this->commandName}\r\n";
        $client = $this->getClient();
        $response = new Response(Response::STATUS_FAILED);
        if ($client->sendCommand($command)) {
            $result = [];
            while (true) {
                $recv = $client->recv();
                if ($recv->getData() === 'END') {
                    $response->setStatus(Response::STATUS_SUCCESS);
                    $response->setData($result);
                    break;
                }
                if ($recv->getStatus() !== ClientResponse::STATUS_OK) {
                    $response->setErrMsg($recv->getMsg());
                    break;
                }
                $data = $recv->getData();
                $dataArr = explode(' ', $data);
                if (!is_numeric($dataArr[1])) {
                    $response->setErrMsg($data);
                    break;
                }
                $result = [
                    'item_size' => $dataArr[1],
                    'item_total' => $dataArr[1]
                ];
            }
        } else {
            $response->setErrMsg($command);
        }
        return $response;
    }

}
