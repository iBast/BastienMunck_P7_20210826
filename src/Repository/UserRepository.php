<?php

namespace App\Repository;

use App\Entity\User;
use App\Entity\Customer;
use App\Repository\AbstractRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method User|null find($id, $lockMode = null, $lockVersion = null)
 * @method User|null findOneBy(array $criteria, array $orderBy = null)
 * @method User[]    findAll()
 * @method User[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class UserRepository extends AbstractRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, User::class);
    }

    public function search($customer, $term, $order = 'asc', $limit = 20, $page = 1)
    {
        $qb = $this
            ->createQueryBuilder('u')
            ->select('u')
            ->orderBy('u.lastName', $order)
            ->where('u.customer = :customer')
            ->setParameter('customer', $customer);

        if ($term) {
            $qb
                ->andwhere('u.lastName LIKE ?1')
                ->setParameter(1, '%' . $term . '%');
        }

        return $this->paginate($qb, $limit, $page);
    }

    // /**
    //  * @return User[] Returns an array of User objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('u')
            ->andWhere('u.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('u.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?User
    {
        return $this->createQueryBuilder('u')
            ->andWhere('u.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
