<?php

namespace AppBundle\Manager;

use AppBundle\Configuration\Server;
use AppBundle\Exception\ServerNotFoundException;

class ServerManager
{
    /** @var Server[]|array */
    protected $servers = [];

    public function __construct(array $servers = [])
    {
        $this->servers = [];

        foreach ($servers as $serverName => $server) {
            $this->servers[$serverName] = new Server($serverName, $server['hostname'], $server['username'], $server['password'], $server['port']);
        }
    }

    /**
     * @return array
     */
    public function getServers()
    {
        return $this->servers;
    }

    public function getServer($name)
    {
        if (isset($this->servers[$name])) {
            return $this->servers[$name];
        }

        throw new ServerNotFoundException($name);
    }
}
