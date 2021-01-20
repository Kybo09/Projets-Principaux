<?php

namespace App\Repository;

use App\Entity\Comment;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Comment|null find($id, $lockMode = null, $lockVersion = null)
 * @method Comment|null findOneBy(array $criteria, array $orderBy = null)
 * @method Comment[]    findAll()
 * @method Comment[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CommentRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Comment::class);
    }

    // /**
    //  * @return Comment[] Returns an array of Comment objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('c')
            ->andWhere('c.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('c.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Comment
    {
        return $this->createQueryBuilder('c')
            ->andWhere('c.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */

    public function getLastComment(int $max = 5){
        $q = $this->createQueryBuilder("c")
            ->andWhere('c.valid = 1')
            ->innerJoin('c.post', 'p')
            ->andWhere('p.publishedAt <= :now')
            ->setParameter('now', new \DateTime())
            ->orderBy('c.createdAt', 'DESC')
            ->setMaxResults($max);

        return $q->getQuery()->getResult();
    }


    public function getValidCommentByIdPost($idpost){
        $q = $this->createQueryBuilder("c")
            ->andWhere('c.valid = 1')
            ->andWhere('c.post = :idpost')
            ->setParameter('idpost', $idpost)
            ->orderBy('c.createdAt', 'DESC');

        return $q->getQuery()->getResult();
    }
}
