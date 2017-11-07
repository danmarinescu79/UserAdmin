<?php

/**
 * @Author: Dan Marinescu
 * @Date:   2017-11-05 07:20:01
 * @Email:  dan.marinescu79@icloud.com
 * @Last Modified by:   Dan Marinescu
 * @Last Modified time: 2017-11-06 13:53:59
 * @Last Modified email: dan.marinescu79@icloud.com
 */

namespace UserAdmin\Controller;

use UserAdmin\Service\User as Service;
use Zend\Crypt\Password\Bcrypt;
use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;

class Admin extends AbstractActionController
{
    protected $service;

    public function __construct(Service $service)
    {
        $this->service = $service;
    }

    public function indexAction()
    {
        $results = $this->service->getPaginated($this->params());

        return new ViewModel([
            'results' => $results
        ]);
    }

    public function addAction()
    {
        $prg = $this->prg();

        if ($prg instanceof \Zend\Http\PhpEnvironment\Response) {
            return $prg;
        }

        $entity = new \UserAdmin\Entity\User;

        $form = $this->service->getForm();

        $form->bind($entity);

        if ($prg !== false) {
            $form->setData($prg);

            if ($form->isValid()) {
                $entity->setPassword((new Bcrypt)->create($entity->getPassword()));
                $this->service->save($entity);
                $this->flashMessenger()->addSuccessMessage(_('User created.'));
                return $this->redirect()->toRoute('user/admin');
            }
        }

        return new ViewModel([
            'form' => $form
        ]);
    }

    public function editAction()
    {
        $prg = $this->prg();

        if ($prg instanceof \Zend\Http\PhpEnvironment\Response) {
            return $prg;
        }

        $userId = $this->params()->fromRoute('userId', false);

        $entity = $this->service->getOne($userId);

        $pass = $entity->getPassword();

        $form = $this->service->getForm(true);

        $form->bind($entity);

        if ($prg !== false) {
            $form->setData($prg);

            if ($form->isValid()) {
                if (!empty($entity->getPassword())) {
                    $pass = (new Bcrypt)->create($entity->getPassword());
                }
                $entity->setPassword($pass);
                $this->service->save($entity);
                $this->flashMessenger()->addSuccessMessage(_('User saved.'));
                return $this->redirect()->toRoute('user/admin');
            }
        }

        return new ViewModel([
            'form' => $form
        ]);
    }
}
