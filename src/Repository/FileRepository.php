<?php

namespace App\Repository;

use App\Entity\File;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<File>
 *
 * @method File|null find($id, $lockMode = null, $lockVersion = null)
 * @method File|null findOneBy(array $criteria, array $orderBy = null)
 * @method File[]    findAll()
 * @method File[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class FileRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, File::class);
    }

    public function save(File $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(File $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    /**
     * Find all files which respect the given criteria.
     * @return File[]
     */
    public function findWithFiltersPaginated(
        array $filters, 
        $orderBy = 'createdAt',
        $orderDirection = 'desc',
        $limit = null,
        $offset = null
        ): array
    {
        $qb = $this->createQueryBuilder('f');
        $qb->where("1 = 1");
        
        foreach ($filters as $filter) {
            $qb->andWhere($filter);
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

    /**
     * Find all files which respect the given criteria(SQLExecution)
     * 
     * 
     * @return File[] $files
     */
    public function findSQLFiltersPaginated(
        array $filters, 
        string $orderBy = 'createdAt',
        string $orderDirection = 'desc',
        int $limit = null,
        int $offset = null
        ): array
    {
        $conn = $this->getEntityManager()->getConnection();

        $sql = 'SELECT * FROM files f WHERE 1 = 1 ';

        $sql = 'SELECT f.id as id FROM file as f 
            INNER JOIN task as t on f.task_id = t.id 
            INNER JOIN project as p on t.project_id = p.id 
            WHERE 1 = 1 ';
        
        foreach ($filters as $filter) {
            $sql .= 'AND '. $filter . ' ';
        }

        $sql.= 'ORDER BY '. $orderBy.' '. $orderDirection . ' ';
        if($limit) {
            $sql.= 'LIMIT '. $limit.' ';
        }
        if($offset) {
            $sql.= 'OFFSET '. $offset;
        }

        $resultSet = $conn->executeQuery($sql);

        // returns an array of arrays (i.e. a raw data set)
        $data = $resultSet->fetchAllAssociative();

        /**
         * @var File[] $files
         */
        $files = [];
        foreach($data as $item)
        {
            $files[] = $this->find($item['id']);
        }

        return $files;
    }

//    /**
//     * @return File[] Returns an array of File objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('f')
//            ->andWhere('f.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('f.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?File
//    {
//        return $this->createQueryBuilder('f')
//            ->andWhere('f.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
