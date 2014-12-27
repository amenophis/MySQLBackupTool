<?php

namespace AppBundle\Configuration;

class Backup
{
    /** @var string */
    protected $name;

    /** @var Server */
    protected $server;

    /** @var string */
    protected $storagePath;

    /** @var string */
    protected $options;

    public function __construct($name, Server $server, $storagePath, $options)
    {
        $this->name = $name;
        $this->server = $server;
        $this->storagePath = rtrim($storagePath, '\\/');
        $this->options = $options;
    }

    /**
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param string $name
     */
    public function setName($name)
    {
        $this->name = $name;
    }

    /**
     * @return Server
     */
    public function getServer()
    {
        return $this->server;
    }

    /**
     * @param Server $server
     */
    public function setServer($server)
    {
        $this->server = $server;
    }

    /**
     * @return string
     */
    public function getStoragePath()
    {
        return $this->storagePath;
    }

    /**
     * @param string $storagePath
     */
    public function setStoragePath($storagePath)
    {
        $this->storagePath = $storagePath;
    }

    /**
     * @return string
     */
    public function getOptions()
    {
        return $this->options;
    }

    /**
     * @param string $options
     */
    public function setOptions($options)
    {
        $this->options = $options;
    }
}
