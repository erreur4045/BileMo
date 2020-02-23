<?php

namespace App\Repository;

use App\Entity\EndUser;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;
use Doctrine\ORM\NonUniqueResultException;
use Doctrine\ORM\NoResultException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

/**
 * @method EndUser|null find($id, $lockMode = null, $lockVersion = null)
 * @method EndUser|null findOneBy(array $criteria, array $orderBy = null)
 * @method EndUser[]    findAll()
 * @method EndUser[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class EndUserRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, EndUser::class);
    }

    public function countEndUsers($clientId)
    {
        try {
            return $this->createQueryBuilder('a')
                ->select('count(a.id)')
                ->where('a.client=' . $clientId)
                ->getQuery()
                ->getSingleScalarResult();
        } catch (NoResultException $e) {
            throw new NotFoundHttpException($e);
        } catch (NonUniqueResultException $e) {
            new NonUniqueResultException($e);
        }
    }
    // /**
    //  * @return EndUser[] Returns an array of EndUser objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('e')
            ->andWhere('e.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('e.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?EndUser
    {
        return $this->createQueryBuilder('e')
            ->andWhere('e.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
