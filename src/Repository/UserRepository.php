<?php

namespace App\Repository;

use App\Entity\User;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\Query\Expr;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<User>
 *
 * @method User|null find($id, $lockMode = null, $lockVersion = null)
 * @method User|null findOneBy(array $criteria, array $orderBy = null)
 * @method User[]    findAll()
 * @method User[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class UserRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, User::class);
    }

    public function save(User $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(User $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    /**
     * Find all users which are not in the specified team.
     * @return User[]
     */
    public function findExcludingTeam(
        int $teamId,
        array $filters = [], 
        ?string $orderBy = 'createdAt',
        ?string $orderDirection = 'desc',
        int $limit = null,
        int $offset = null
        ): array
    {
        $qb = $this->createQueryBuilder('u');
        $qb->leftJoin('u.teammates', 'tm');
        $qb->leftJoin('tm.team', 't', Expr\Join::WITH, "t.id != $teamId");
        $qb->where("1 = 1");

        foreach ($filters as $filter) {
            $qb->andWhere($filter);
        }
        if(!$orderBy || strpos($orderBy, 'p.') === false) {
            $orderBy = 'p.createdAt';
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
//     * @return User[] Returns an array of User objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('u')
//            ->andWhere('u.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('u.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?User
//    {
//        return $this->createQueryBuilder('u')
//            ->andWhere('u.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
