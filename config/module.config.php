<?php

/**
 * @Author: Dan Marinescu
 * @Date:   2017-11-05 05:36:02
 * @Email:  dan.marinescu79@icloud.com
 * @Last Modified by:   Dan Marinescu
 * @Last Modified time: 2017-11-05 07:00:13
 * @Last Modified email: dan.marinescu79@icloud.com
 */

namespace UserAdmin;

use Doctrine\ORM\Mapping\Driver\AnnotationDriver;
use Zend\Router\Http\Segment;

return [
    'router' => [
        'routes' => [
            'account' => [
                'type'    => Segment::class,
                'options' => [
                    'route'    => '/account',
                    'defaults' => [
                        'controller' => Controller\User::class,
                        'action'     => 'index',
                    ],
                ],
            ],
            'login' => [
                'type'    => Segment::class,
                'options' => [
                    'route'    => '/login',
                    'defaults' => [
                        'controller' => Controller\User::class,
                        'action'     => 'login',
                    ],
                ],
            ],
            'logout' => [
                'type'    => Segment::class,
                'options' => [
                    'route'    => '/logout',
                    'defaults' => [
                        'controller' => Controller\User::class,
                        'action'     => 'logout',
                    ],
                ],
            ],
        ],
    ],
    'view_manager' => [
        'template_path_stack' => [
            __DIR__ . '/../view',
        ],
    ],
    'controllers' => [
        'factories' => [
            Controller\User::class => Factory\Controller\User::class,
        ],
    ],
    'service_manager' => [
        'factories' => [
            Service\User::class => Factory\Service\User::class,
        ],
    ],
    'doctrine' => [
        'authentication' => [
            'orm_default' => [
                'object_manager'      => \Doctrine\ORM\EntityManager::class,
                'identity_class'      => \UserAdmin\Entity\User::class,
                'identity_property'   => 'email',
                'credential_property' => 'password',
                'credential_callable' => 'UserAdmin\Service\User::verifyCredential'
            ],
        ],
        'driver' => [
            __NAMESPACE__ . '_driver' => [
                'class' => AnnotationDriver::class,
                'paths' => [__DIR__ . '/../src/Entity']
            ],
            'orm_default' => [
                'drivers' => [
                    __NAMESPACE__ . '\Entity' => __NAMESPACE__ . '_driver'
                ]
            ],
        ]
    ]
];
