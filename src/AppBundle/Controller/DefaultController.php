<?php

namespace AppBundle\Controller;

use AppBundle\Exception\BackupNotFoundException;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    /**
     * @Route("/", name="homepage")
     */
    public function indexAction()
    {
        return $this->render('default/index.html.twig');
    }

    /**
     * @Route("/backup/{backupName}", name="backup_show", requirements={"backupName": "\w+"})
     */
    public function backupShowAction($backupName)
    {
        try {
            return $this->render(
                'default/backupShow.html.twig',
                [
                    'backup' => $this->get('app.manager.backup')->getBackup($backupName)
                ]
            );
        } catch (BackupNotFoundException $e) {
            throw $this->createNotFoundException($e->getMessage(), $e);
        }
    }
}
