<?php

namespace App\Repository;

use App\Entity\Team;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\Query\Expr;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Team>
 *
 * @method Team|null find($id, $lockMode = null, $lockVersion = null)
 * @method Team|null findOneBy(array $criteria, array $orderBy = null)
 * @method Team[]    findAll()
 * @method Team[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class TeamRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Team::class);
    }

    public function save(Team $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(Team $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    /**
     * Find all teams which respect the given criteria.
     * @return Team[]
     */
    public function findByUser(
        int $userId,
        array $filters = [], 
        ?string $orderBy = 'createdAt',
        ?string $orderDirection = 'desc',
        int $limit = null,
        int $offset = null
        ): array
    {
        $qb = $this->createQueryBuilder('t');
        $qb->innerJoin('t.teammates', 'tm');
        $qb->innerJoin('tm.user', 'u', Expr\Join::WITH, "u.id = $userId");
        $qb->where("1 = 1");

        foreach ($filters as $filter) {
            $qb->andWhere($filter);
        }
        if(!$orderBy || strpos($orderBy, 't.') === false) {
            $orderBy = 't.createdAt';
        }
        if(!$orderDirection){
            $orderDirection = 'desc';
        }
        $qb->orderBy($orderBy, $orderDirection);
        if($limit) {
            $qb->setMaxResults($limit);
        }
        if($offset) {
            $qb->setFirstResult($offset);
        }

        return $qb->getQuery()->getResult();
    }

//    /**
//     * @return Team[] Returns an array of Team objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('t')
//            ->andWhere('t.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('t.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?Team
//    {
//        return $this->createQueryBuilder('t')
//            ->andWhere('t.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
