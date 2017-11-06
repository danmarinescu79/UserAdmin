<?php

/**
 * @Author: Dan Marinescu
 * @Date:   2017-11-05 06:54:45
 * @Email:  dan.marinescu79@icloud.com
 * @Last Modified by:   Dan Marinescu
 * @Last Modified time: 2017-11-05 07:22:59
 * @Last Modified email: dan.marinescu79@icloud.com
 */

namespace UserAdmin\Service;

use Doctrine\Common\Persistence\ObjectManager;
use UserAdmin\Entity\User as UserEntity;
use Zend\Crypt\Password\Bcrypt;
use Zend\Mvc\Controller\Plugin\Params;

class User
{
    protected $objectManager;

    public function __construct(ObjectManager $objectManager)
    {
        $this->objectManager = $objectManager;
    }

    public function save(UserEntity $user)
    {
        $this->objectManager->persist($user);
        $this->objectManager->flush();
    }

    public function getOne($userId)
    {
        return $this->objectManager->find(UserEntity::class, $userId);
    }

    public function getPaginated(Params $params = null)
    {
        return $this->objectManager->getRepository(UserEntity::class)->getPaginated($params);
    }

    public function getLoginForm()
    {
        return new \UserAdmin\Form\Login($this->objectManager);
    }
    
    public static function verifyCredential(UserEntity $user, $password)
    {
        return (new Bcrypt())->verify($password, $user->getPassword());
    }

    public function getForm($edit = false)
    {
        if ($edit) {
            return new \UserAdmin\Form\EditUser($this->objectManager);
        }
        return new \UserAdmin\Form\User($this->objectManager);
    }
}
