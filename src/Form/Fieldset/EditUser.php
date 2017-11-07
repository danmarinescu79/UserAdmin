<?php

/**
 * @Author: Dan Marinescu
 * @Date:   2017-11-06 14:04:54
 * @Email:  dan.marinescu79@icloud.com
 * @Last Modified by:   Dan Marinescu
 * @Last Modified time: 2017-11-06 14:10:11
 * @Last Modified email: dan.marinescu79@icloud.com
 */

namespace UserAdmin\Form\Fieldset;

use AclAdmin\Entity\Role as RoleEntity;
use Doctrine\Common\Persistence\ObjectManager;
use DoctrineModule\Form\Element\ObjectSelect;
use DoctrineModule\Stdlib\Hydrator\DoctrineObject as DoctrineHydrator;
use DoctrineModule\Validator;
use UserAdmin\Entity\User as UserEntity;
use Zend\Form\Element;
use Zend\Form\Fieldset;
use Zend\InputFilter\InputFilterProviderInterface;

class EditUser extends Fieldset implements InputFilterProviderInterface
{
    public function __construct(ObjectManager $objectManager)
    {
        parent::__construct('user');

        $this->objectManager = $objectManager;

        $this->setHydrator(new DoctrineHydrator($objectManager))->setObject(new UserEntity());

        $this->add([
            'type' => 'hidden',
            'name' => 'id'
        ]);

        $this->add([
            'type'    => Element\Email::class,
            'name'    => 'email',
            'options' => [
                'label' => _('Email'),
            ],
            'attributes' => [
                'placeholder' => _('Email'),
                'class'       => 'form-control input-sm',
            ],
        ]);

        $this->add([
            'type'    => Element\Password::class,
            'name'    => 'password',
            'options' => [
                'label' => _('Password'),
            ],
            'attributes' => [
                'placeholder' => _('Password'),
                'class'       => 'form-control input-sm',
            ],
        ]);

        $this->add([
            'type'    => Element\Password::class,
            'name'    => 'verify_password',
            'options' => [
                'label' => _('Confirm Password'),
            ],
            'attributes' => [
                'placeholder' => _('Confirm Password'),
                'class'       => 'form-control input-sm',
            ],
        ]);

        $this->add([
            'type'    => ObjectSelect::class,
            'name'    => 'role',
            'options' => [
                'object_manager'     => $this->objectManager,
                'target_class'       => RoleEntity::class,
                'property'           => 'role',
                'label'              => _('Role'),
                'display_empty_item' => true,
                'empty_item_label'   => _(' - Choose Role - '),
            ],
            'attributes' => [
                'class' => 'form-control',
            ],
        ]);
    }

     /**
      * @return array
      */
    public function getInputFilterSpecification()
    {
        return [
            'id' => [
                'required'    => true,
                'allow_empty' => true,
            ],
            'email' => [
                'required'    => true,
                'allow_empty' => false,
                'validators'  => [
                    [
                        'name'    => 'EmailAddress',
                    ],
                    [
                        'name'    => Validator\UniqueObject::class,
                        'options' => [
                            'object_repository' => $this->objectManager->getRepository(UserEntity::class),
                            'object_manager'    => $this->objectManager,
                            'fields'            => ['email'],
                            'use_context'       => true,
                        ],
                    ],
                ],
            ],
            'password' => [
                'required'    => true,
                'allow_empty' => true,
                'validators'  => [
                    [
                        'name'    => 'StringLength',
                        'options' => [
                            'min' => 8,
                            'max' => 30,
                        ],
                    ],
                ],
            ],
            'verify_password' => [
                'required'    => true,
                'allow_empty' => true,
                'validators'  => [
                    [
                        'name'    => 'StringLength',
                        'options' => [
                            'min' => 8,
                            'max' => 30,
                        ],
                    ],
                    [
                        'name'    => 'Identical',
                        'options' => [
                            'token' => 'password',
                        ],
                    ],
                ],
            ],
            'role' => [
                'required' => true,
            ],
        ];
    }
}
