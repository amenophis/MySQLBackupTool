<?php

namespace AppBundle\Twig;

use AppBundle\Manager\BackupManager;
use AppBundle\Manager\ServerManager;

class AppExtension extends \Twig_Extension
{
    protected $serverManager;

    protected $backupManager;

    public function __construct(ServerManager $serverManager, BackupManager $backupManager)
    {
        $this->serverManager = $serverManager;
        $this->backupManager = $backupManager;
    }

    public function getFunctions()
    {
        return [
            new \Twig_SimpleFunction('mbt_servers', [$this, 'getServers']),
            new \Twig_SimpleFunction('mbt_backups', [$this, 'getBackups']),
        ];
    }

    public function getFilters()
    {
        return [
            new \Twig_SimpleFilter('password', [$this, 'hidePassword']),
        ];
    }

    public function getServers()
    {
        return $this->serverManager->getServers();
    }

    public function getBackups()
    {
        return $this->backupManager->getBackups();
    }

    public function hidePassword($value)
    {
        $newValue = "";
        for ($i = 0; $i<strlen($value); $i++) {
            if ($i > 0 && $i < strlen($value)-1) {
                $newValue .= '*';
            } else {
                $newValue .= substr($value, $i, 1);
            }
        }

        return $newValue;
    }

    public function getName()
    {
        return 'app_extension';
    }
}
