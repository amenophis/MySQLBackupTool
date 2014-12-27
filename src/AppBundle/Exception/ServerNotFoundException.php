<?php

namespace AppBundle\Exception;

class ServerNotFoundException extends \Exception
{
    public function __construct()
    {
        parent::__construct("Server not found");
    }
}
