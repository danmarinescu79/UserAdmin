<?php

/**
 * @Author: Dan Marinescu
 * @Date:   2017-11-05 06:57:14
 * @Email:  dan.marinescu79@icloud.com
 * @Last Modified by:   Dan Marinescu
 * @Last Modified time: 2017-11-05 06:58:38
 * @Last Modified email: dan.marinescu79@icloud.com
 */

namespace UserAdmin\Listener;

use Doctrine\Common\Persistence\ObjectManager;
use DoctrineModule\Stdlib\Hydrator\DoctrineObject;
use UserAdmin\Entity\User;

class EntityListener
{
    private $objectManager;
    private $hydrator;

    public function __construct(ObjectManager $objectManager)
    {
        $this->objectManager = $objectManager;
        $this->hydrator      = new DoctrineObject($objectManager);
    }

    public function prePersist($eventArgs)
    {
        $entity              = $eventArgs->getEntity();
        $identity            = Identity::identity();

        if (method_exists($entity, 'setCreatedat')) {
            $entity->setCreatedat(new \DateTime());
        }

        if (method_exists($entity, 'setCreatedby')) {
            if ($identity) {
                $user = $this->objectManager->find(User::class, $identity['id']);
                $entity->setCreatedby($user);
            }
        }
    }

    public function preUpdate($eventArgs)
    {
        $entity              = $eventArgs->getEntity();
        $identity            = Identity::identity();

        if (method_exists($entity, 'setUpdatedat')) {
            $entity->setUpdatedat(new \DateTime());
        }

        if (method_exists($entity, 'setUpdatedby')) {
            if ($identity) {
                $user = $this->objectManager->find(User::class, $identity['id']);
                $entity->setUpdatedby($user);
            }
        }
    }
}
