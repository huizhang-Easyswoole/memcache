<?php

namespace Huizhang\Memcache;

class Config
{

    private $servers = [];

    public function getServers(): array
    {
        return $this->servers;
    }

    public function setServers(array $servers): Config
    {
        $this->servers = $servers;
        return $this;
    }

}
