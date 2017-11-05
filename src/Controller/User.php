<?php

/**
 * @Author: Dan Marinescu
 * @Date:   2017-11-05 06:52:10
 * @Email:  dan.marinescu79@icloud.com
 * @Last Modified by:   Dan Marinescu
 * @Last Modified time: 2017-11-05 06:52:53
 * @Last Modified email: dan.marinescu79@icloud.com
 */

namespace UserAdmin\Controller;

use UserAdmin\Service\User as Service;
use Zend\Authentication\AuthenticationService;
use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;

class User extends AbstractActionController
{
    protected $service;

    public function __construct(Service $service, AuthenticationService $authService)
    {
        $this->service     = $service;
        $this->authService = $authService;
    }

    public function indexAction()
    {
        return new ViewModel([
        ]);
    }

    public function loginAction()
    {
        $prg = $this->prg();
        
        if ($prg instanceof \Zend\Http\PhpEnvironment\Response) {
            return $prg;
        }

        $form = $this->service->getLoginForm();
        $user = new \UserAdmin\Entity\User;

        $form->bind($user);

        if ($prg !== false) {
            $form->setData($prg);

            if ($form->isValid()) {
                $adapter = $this->authService->getAdapter();
                $adapter->setIdentity($user->getEmail());
                $adapter->setCredential($user->getPassword());
                $authResult = $this->authService->authenticate();

                if ($authResult->isValid()) {
                    return $this->redirect()->toRoute('account');
                } else {
                    $form->get('password')->setMessages($authResult->getMessages());
                }
            }
        }

        return new ViewModel([
            'form' => $form,
        ]);
    }

    public function logoutAction()
    {
        $this->authService->clearIdentity();
        return $this->redirect()->toRoute('home');
    }
}
