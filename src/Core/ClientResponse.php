<?php

namespace Huizhang\MemcacheClient\Core;

class ClientResponse
{
    private $status = self::STATUS_OK;
    private $msg;
    private $data;

    public const STATUS_OK = 1;
    public const STATUS_TIMEOUT = 2;

    public function setData(string $data): ClientResponse
    {
        $this->data = $data;
        return $this;
    }

    public function getData()
    {
        return $this->data;
    }

    public function setStatus(int $status): ClientResponse
    {
        $this->status = $status;
        return $this;
    }

    public function getStatus(): int
    {
        return $this->status;
    }

    public function setMsg($msg): ClientResponse
    {
        $this->msg = $msg;
        return $this;
    }

    public function getMsg()
    {
        return $this->msg;
    }

}
