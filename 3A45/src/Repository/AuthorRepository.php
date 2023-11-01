<?php

namespace App\Repository;

use App\Entity\Author;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Author>
 *
 * @method Author|null find($id, $lockMode = null, $lockVersion = null)
 * @method Author|null findOneBy(array $criteria, array $orderBy = null)
 * @method Author[]    findAll()
 * @method Author[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class AuthorRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Author::class);
    }
    public function listAuthorByEmail(){
        return $this->createQueryBuilder('a')
            ->orderBy('a.email','ASC')
            ->getQuery()
            ->getResult();


    }
    function SearchAuthorDQL($min,$max){
        $em=$this->getEntityManager();
        return $em->createQuery(
            'select a from App\Entity\Author a WHERE 
        a.nb_books BETWEEN ?1 AND ?2')
            ->setParameter(1,$min)
            ->setParameter(2,$max)
            ->getResult();
    }
    function SearchAuthorDQLByFirstCaracterName(){
        $em=$this->getEntityManager();
        return $em->createQuery(
            'select COUNT(a) from App\Entity\Author a WHERE 
        a.nb_books > 0')
            ->getSingleScalarResult();
    }


//    /**
//     * @return Author[] Returns an array of Author objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('a')
//            ->andWhere('a.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('a.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?Author
//    {
//        return $this->createQueryBuilder('a')
//            ->andWhere('a.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
