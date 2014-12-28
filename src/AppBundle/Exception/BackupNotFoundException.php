<?php

namespace AppBundle\Exception;

class BackupNotFoundException extends \Exception
{
    public function __construct($backupName)
    {
        parent::__construct(sprintf("Backup '%s' not found", $backupName));
    }
}
