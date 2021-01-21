<?php

namespace Huizhang\Memcache\CommandHandler;

use Huizhang\Memcache\Core\ClientResponse;

class Set extends CommandHandlerAbstract
{

    protected $commandName = 'set';

    public function handler(...$data)
    {
        [$key, $value ,$expire] = $data;
        $command = sprintf(
            "%s %s 0 %s %s \r\n"
            , $this->commandName
            , $key
            , $expire
            , strlen($value)
        );
        $client = $this->getClient();
        if ($client->sendCommand($command)) {
            $command = sprintf("%s\r\n", $value);
            if ($client->sendCommand($command)) {
                $result = $client->recv();
                if ($result->getStatus() === ClientResponse::STATUS_OK) {
                    return $result->getData() === 'STORED';
                } else {
                    return false;
                }
            }
            return false;
        }
        return false;
    }

}
