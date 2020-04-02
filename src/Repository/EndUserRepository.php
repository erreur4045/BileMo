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
            return $this->createQueryBuilder('a')
                ->select('count(a.id)')
                ->where('a.client=' . $clientId)
                ->getQuery()
                ->getSingleScalarResult();
    }
}
