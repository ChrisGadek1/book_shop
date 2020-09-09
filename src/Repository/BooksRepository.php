<?php

namespace App\Repository;

use App\Entity\Books;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Books|null find($id, $lockMode = null, $lockVersion = null)
 * @method Books|null findOneBy(array $criteria, array $orderBy = null)
 * @method Books[]    findAll()
 * @method Books[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class BooksRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Books::class);
    }

    // /**
    //  * @return Books[] Returns an array of Books objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('b')
            ->andWhere('b.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('b.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Books
    {
        return $this->createQueryBuilder('b')
            ->andWhere('b.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
    /**
     * @return Books[]
     */
    public function get4Newest():array{
        return $this->getEntityManager()->createQuery("SELECT e FROM App\Entity\Books e ORDER BY e.date_of_adding DESC")->setMaxResults(4)->getResult();
    }

    public function findElements($thing, $subcat):array{
        $subcat = str_replace("-", " ",$subcat);
        return $this->getEntityManager()->createQuery("SELECT e FROM App\Entity\Books e WHERE e.category= :thing AND e.subcategory= :subcat ORDER BY e.date_of_adding DESC")
            ->setParameter('thing',$thing)
            ->setParameter('subcat',$subcat)->getResult();
    }
    public function findById($id){
        return $this->getEntityManager()->createQuery("SELECT e FROM App\Entity\Books e WHERE e.id= :id")->setParameter('id',$id)->getResult();
    }
}
