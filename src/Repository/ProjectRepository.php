<?php

namespace App\Repository;

use App\Entity\Project;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\Query\Expr;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Project>
 *
 * @method Project|null find($id, $lockMode = null, $lockVersion = null)
 * @method Project|null findOneBy(array $criteria, array $orderBy = null)
 * @method Project[]    findAll()
 * @method Project[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ProjectRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Project::class);
    }

    public function save(Project $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(Project $entity, bool $flush = false): void
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
        $qb = $this->createQueryBuilder('p');
        $qb->innerJoin('p.team', 't');
        $qb->innerJoin('t.teammates', 'tm');
        $qb->innerJoin('tm.user', 'u', Expr\Join::WITH, "u.id = $userId");
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
//     * @return Project[] Returns an array of Project objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('p')
//            ->andWhere('p.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('p.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?Project
//    {
//        return $this->createQueryBuilder('p')
//            ->andWhere('p.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
