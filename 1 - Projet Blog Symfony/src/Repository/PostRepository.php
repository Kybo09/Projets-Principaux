<?php

namespace App\Repository;

use App\Entity\Post;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Collections\Collection;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Post|null find($id, $lockMode = null, $lockVersion = null)
 * @method Post|null findOneBy(array $criteria, array $orderBy = null)
 * @method Post[]    findAll()
 * @method Post[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class PostRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Post::class);
    }

    // /**
    //  * @return Post[] Returns an array of Post objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('p.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Post
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */

    public function getPublishedPost(int $offset = null, int $max = null){
        $q = $this->createQueryBuilder("p")
            ->andWhere('p.publishedAt <= :now')
            ->setParameter('now', new \DateTime())
            ->orderBy('p.publishedAt', 'DESC');
        if ($offset) {
            $q->setFirstResult($offset-$max);
        }
        if ($max) {
            $q->setMaxResults($max);
        }
        return $q->getQuery()->getResult();

    }

    public function getPostByCategory($idcat){
        $q = $this->createQueryBuilder("p")
            ->innerJoin('p.categories', 'categories')
            ->andWhere('categories.id = :idcat')
            ->andWhere('p.publishedAt <= :now')
            ->setParameter('now', new \DateTime())
            ->setParameter('idcat', $idcat)
            ->orderBy('p.publishedAt', 'DESC');

        return $q->getQuery()->getResult();
    }
}
