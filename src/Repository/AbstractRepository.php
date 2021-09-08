<?php

namespace App\Repository;

use Pagerfanta\Pagerfanta;
use Doctrine\ORM\QueryBuilder;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Pagerfanta\Doctrine\ORM\QueryAdapter;

abstract class AbstractRepository extends ServiceEntityRepository
{
    protected function paginate(QueryBuilder $qb, $limit = 5, $page = 1)
    {
        if (!($limit > 0 && $page > 0)) {
            throw new \LogicException('$limit & $offset must be greater than 0.');
        }

        $pager = new Pagerfanta(new QueryAdapter($qb));

        $currentPage = $page;
        $pager->setMaxPerPage((int) $limit);
        $pager->setCurrentPage($currentPage > $pager->getNbPages() ? $pager->getNbPages() : $currentPage);

        return $pager;
    }
}
