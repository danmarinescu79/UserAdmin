<?php

/**
 * @Author: Dan Marinescu
 * @Date:   2017-11-05 06:54:04
 * @Email:  dan.marinescu79@icloud.com
 * @Last Modified by:   Dan Marinescu
 * @Last Modified time: 2017-11-05 06:54:31
 * @Last Modified email: dan.marinescu79@icloud.com
 */

namespace UserAdmin\Factory\Service;

use Interop\Container\ContainerInterface;
use UserAdmin\Service\User as Service;
use Zend\ServiceManager\Factory\FactoryInterface;

class User implements FactoryInterface
{
    public function __invoke(ContainerInterface $container, $requestedName, array $options = null)
    {
        return new Service(
            $container->get(\Doctrine\ORM\EntityManager::class)
        );
    }
}
