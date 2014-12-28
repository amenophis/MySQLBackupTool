<?php

namespace AppBundle\Exception;

class UserNotFoundException extends \Exception
{
    public function __construct($name)
    {
        parent::__construct(sprintf("User '%s' not found", $name));
    }
}
