<?php

namespace AppBundle\Exception;

class BackupNotFoundException extends \Exception
{
    public function __construct()
    {
        parent::__construct("Backup not found");
    }
}
