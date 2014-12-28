<?php

namespace AppBundle\Exception;

class ServerNotFoundException extends \Exception
{
    public function __construct($name)
    {
        parent::__construct(sprintf("Server '%s' not found", $name));
    }
}
