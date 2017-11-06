<?php

/**
 * @Author: Dan Marinescu
 * @Date:   2017-11-05 07:23:27
 * @Email:  dan.marinescu79@icloud.com
 * @Last Modified by:   Dan Marinescu
 * @Last Modified time: 2017-11-05 07:24:52
 * @Last Modified email: dan.marinescu79@icloud.com
 */

namespace UserAdmin\Repository;

use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\Tools\Pagination\Paginator as ORMPaginator;
use DoctrineORMModule\Paginator\Adapter\DoctrinePaginator as PageAdapter;
use Zend\Mvc\Controller\Plugin\Params;
use Zend\Paginator\Paginator as ZendPaginator;

class User extends EntityRepository
{
    public function getPaginated(Params $params)
    {
        $page         = $params->fromQuery('page', 1);
        $perPage      = $params->fromQuery('perPage', 20);
        $queryBuilder = $this->createQueryBuilder('User');

        $paginator = new ZendPaginator(new PageAdapter(new ORMPaginator($queryBuilder->getQuery())));

        return $paginator->setCurrentPageNumber($page)->setItemCountPerPage($perPage);
    }
}
