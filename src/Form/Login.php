<?php

/**
 * @Author: Dan Marinescu
 * @Date:   2017-11-05 06:55:35
 * @Email:  dan.marinescu79@icloud.com
 * @Last Modified by:   Dan Marinescu
 * @Last Modified time: 2017-11-05 07:09:45
 * @Last Modified email: dan.marinescu79@icloud.com
 */

namespace UserAdmin\Form;

use Doctrine\Common\Persistence\ObjectManager;
use DoctrineModule\Stdlib\Hydrator\DoctrineObject as DoctrineHydrator;
use DoctrineModule\Validator\ObjectExists;
use UserAdmin\Entity\User as Entity;
use Zend\Form\Element;
use Zend\Form\Form;
use Zend\InputFilter\InputFilterProviderInterface;

class Login extends Form implements InputFilterProviderInterface
{
    protected $objectManager;

    public function __construct(ObjectManager $objectManager)
    {
        parent::__construct('user');

        $this->objectManager = $objectManager;

        $this->setHydrator(new DoctrineHydrator($objectManager))->setObject(new Entity());

        $this->add([
            'type'    => Element\Email::class,
            'name'    => 'email',
            'options' => [
                'label' => _('Email'),
            ],
            'attributes' => [
                'placeholder' => _('Email'),
                'class'       => 'form-control',
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
                'class'       => 'form-control',
            ],
        ]);

        $this->add(new Element\Csrf('security'));

        $this->add([
            'name'       => 'submit',
            'type'       => Element\Button::class,
            'options'    => [
                'label' => _('LOG IN'),
            ],
            'attributes' => [
                'class' => 'btn btn-primary btn-block',
                'type'  => 'submit',
            ],
        ]);

        $this->setValidationGroup([
            'security',
            'email',
            'password',
        ]);
    }

     /**
      * @return array
      */
    public function getInputFilterSpecification()
    {
        return [
            'email' => [
                'required'    => true,
                'allow_empty' => false,
                'validators'  => [
                    [
                        'name'    => 'EmailAddress',
                    ],
                    [
                        'name'    => ObjectExists::class,
                        'options' => [
                            'object_repository' => $this->objectManager->getRepository(Entity::class),
                            'fields'            => 'email',
                        ],
                    ],
                ],
            ],
            'password' => [
                'required'   => true,
                'validators' => [
                    [
                        'name'    => 'StringLength',
                        'options' => [
                            'min' => 8,
                            'max' => 30,
                        ],
                    ],
                ],
            ],
        ];
    }
}
