<?php

/**
 * @Author: Dan Marinescu
 * @Date:   2017-11-06 14:01:33
 * @Email:  dan.marinescu79@icloud.com
 * @Last Modified by:   Dan Marinescu
 * @Last Modified time: 2017-11-06 14:02:23
 * @Last Modified email: dan.marinescu79@icloud.com
 */

namespace UserAdmin\Form;

use Doctrine\Common\Persistence\ObjectManager;
use UserAdmin\Form\Fieldset\User as Fieldset;
use Zend\Form\Element;
use Zend\Form\Form;

class User extends Form
{
    protected $objectManager;

    public function __construct(ObjectManager $objectManager)
    {
        $this->objectManager = $objectManager;

        parent::__construct();

        $userFieldset = new Fieldset($this->objectManager);
        $userFieldset->setUseAsBaseFieldset(true);
        $this->add($userFieldset);

        $this->add(new Element\Csrf('security'));

        $this->add([
            'name'       => 'submit',
            'type'       => Element\Submit::class,
            'attributes' => [
                'value' => _('Save'),
                'class' => 'btn btn-md btn-primary btn-center',
            ],
        ]);

        $this->setValidationGroup([
            'security',
            'user' => [
                'id',
                'email',
                'role',
                'password',
                'verify_password',
            ],
        ]);
    }
}
