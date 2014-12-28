<?php

namespace AppBundle\Manager;

use AppBundle\Configuration\Backup;
use AppBundle\Exception\BackupNotFoundException;
use AppBundle\Exception\MySQLDumpException;
use Symfony\Component\Process\Process;

class BackupManager
{
    /** @var Backup[]|array */
    protected $backups = [];

    /** @var ServerManager */
    protected $serverManager;

    /**
     * @param array         $backups
     * @param ServerManager $serverManager
     *
     * @throws \Exception
     */
    public function __construct(array $backups = [], ServerManager $serverManager)
    {
        $this->backups = [];
        $this->serverManager = $serverManager;

        foreach ($backups as $backupName => $backup) {
            $this->backups[$backupName] = new Backup($backupName, $serverManager->getServer($backup['server']), $backup['storage_path'], $backup['options']);
        }
    }

    /**
     * @return array
     */
    public function getBackups()
    {
        return $this->backups;
    }

    /**
     * @param $backupName
     *
     * @return Backup
     * @throws \Exception
     */
    public function getBackup($backupName)
    {
        if (isset($this->backups[$backupName])) {
            return $this->backups[$backupName];
        }

        throw new BackupNotFoundException($backupName);
    }

    /**
     * @param Backup $backup
     *
     * @throws MySQLDumpException
     */
    public function execute(Backup $backup)
    {
        $filename = sprintf(
            '%s%s%s-%s.sql',
            $backup->getStoragePath(),
            DIRECTORY_SEPARATOR,
            $backup->getName(),
            date('YmdGis')
        );

        $commandline = sprintf(
            'mysqldump --host=%s --user=%s --password=%s %s > %s',
            $backup->getServer()->getHostname(),
            $backup->getServer()->getUsername(),
            $backup->getServer()->getPassword(),
            $backup->getOptions(),
            $filename
        );

        $process = new Process($commandline);
        $process->run();

        if ($process->getExitCode() > 0) {
            throw new MySQLDumpException($process->getExitCodeText(), $process->getExitCode());
        }
    }

    public function restore(Backup $backup, $filename)
    {
        $commandline = sprintf(
            'mysql --host=%s --user=%s --password=%s < %s',
            $backup->getServer()->getHostname(),
            $backup->getServer()->getUsername(),
            $backup->getServer()->getPassword(),
            $backup->getOptions(),
            $filename
        );

        $process = new Process($commandline);
        $process->run();

        if ($process->getExitCode() > 0) {
            //throw new MySQLDumpException($process->getExitCodeText(), $process->getExitCode());
        }
    }
}
