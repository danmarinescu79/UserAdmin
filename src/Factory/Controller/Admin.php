<?php

/**
 * @Author: Dan Marinescu
 * @Date:   2017-11-05 07:21:47
 * @Email:  dan.marinescu79@icloud.com
 * @Last Modified by:   Dan Marinescu
 * @Last Modified time: 2017-11-05 07:22:12
 * @Last Modified email: dan.marinescu79@icloud.com
 */

namespace UserAdmin\Factory\Controller;

use Interop\Container\ContainerInterface;
use UserAdmin\Controller\Admin as Controller;
use Zend\ServiceManager\Factory\FactoryInterface;

class Admin implements FactoryInterface
{
    public function __invoke(ContainerInterface $container, $requestedName, array $options = null)
    {
        return new Controller(
            $container->get(\UserAdmin\Service\User::class)
        );
    }
}
