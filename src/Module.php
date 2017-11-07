<?php

/**
 * @Author: Dan Marinescu
 * @Date:   2017-11-05 05:35:03
 * @Email:  dan.marinescu79@icloud.com
 * @Last Modified by:   Dan Marinescu
 * @Last Modified time: 2017-11-06 14:16:26
 * @Last Modified email: dan.marinescu79@icloud.com
 */

namespace UserAdmin;

use Zend\EventManager\EventInterface as MvcEvent;

class Module
{
    const VERSION = '0.1';

    public function getConfig()
    {
        return include __DIR__ . '/../config/module.config.php';
    }

    public function onBootstrap(MvcEvent $e)
    {
        $application           = $e->getApplication();
        $sm                    = $application->getServiceManager();
        $doctrineEntityManager = $sm->get('doctrine.entitymanager.orm_default');
        $doctrineEventManager  = $doctrineEntityManager->getEventManager();
        $doctrineEventManager->addEventListener(
            [
                \Doctrine\ORM\Events::prePersist,
                \Doctrine\ORM\Events::preUpdate
            ],
            new \UserAdmin\Listener\EntityListener($doctrineEntityManager)
        );
    }
}
