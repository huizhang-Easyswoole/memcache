<?php
/**
 * @CreateTime:   2021/1/23 10:29 下午
 * @Author:       huizhang  <2788828128@qq.com>
 * @Copyright:    copyright(2020) Easyswoole all rights reserved
 * @Description:  gets command handler
 */
namespace Huizhang\Memcache\CommandHandler;

use Huizhang\Memcache\Core\ClientResponse;
use Huizhang\Memcache\Core\MemcacheResponse;

class Gets extends CommandHandlerAbstract
{

    protected $commandName = 'gets';

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
            $key = $cas = null;
            while (true) {
                $recv = $client->recv();
                if ($recv->getData() === 'END') {
                    break;
                }
                if ($recv->getStatus() !== ClientResponse::STATUS_OK) {
                    $response->setErrMsg($recv->getMsg());
                    break;
                }
                $data = $recv->getData();
                $dataArr = explode(' ', $data);
                if (count($dataArr) === 5) {
                    $key = $dataArr[1];
                    $cas = $dataArr[4];
                } else {
                    $result[$key] = [
                        'value' => $data,
                        'cas' => $cas
                    ];
                }
            }
            if (!empty($result)) {
                $response->setStatus(MemcacheResponse::STATUS_SUCCESS);
                $response->setData($result);
            }
        } else {
            $response->setErrMsg($command);
        }
        return $response;
    }
}
