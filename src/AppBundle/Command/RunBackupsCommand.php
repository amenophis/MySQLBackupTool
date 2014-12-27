<?php

namespace AppBundle\Command;

use AppBundle\Exception\MySQLDumpException;
use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class RunBackupsCommand extends ContainerAwareCommand
{
    protected function configure()
    {
        $this
            ->setName('mbt:run-backups')
            ->setDescription('Run backups')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $backupManager = $this->getContainer()->get('app.manager.backup');

        foreach ($backupManager->getBackups() as $backupName => $backup) {
            try {
                $output->write(sprintf("Execute %s ...", $backupName));
                $backupManager->execute($backup);
                $output->write(" <info>Done</info>", true);
            } catch (MySQLDumpException $e) {
                $output->write(" <error>Error</error>", true);
                $output->writeln($e->getMessage());
            }
        }
    }
}
