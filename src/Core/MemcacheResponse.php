<?php

namespace Huizhang\Memcache\Core;

class MemcacheResponse
{

    public const STATUS_SUCCESS = 1;
    public const STATUS_FAILED = -1;

    public $status;
    public $errMsg;
    public $data;

    public function __construct($status = self::STATUS_SUCCESS, $errMsg = '', $data = null)
    {
        $this->status = $status;
        $this->errMsg = $errMsg;
        $this->data = $data;
    }

    public function setStatus($status)
    {
        $this->status = $status;
        return $this;
    }

    public function setErrMsg($errMsg)
    {
        $this->errMsg = $errMsg;
        return $this;
    }

    public function setData($data): MemcacheResponse
    {
        $this->data = $data;
        return $this;
    }

    public function getStatus()
    {
        return $this->status;
    }

    public function getErrMsg()
    {
        return $this->errMsg;
    }

    public function getData()
    {
        return $this->data;
    }

}
