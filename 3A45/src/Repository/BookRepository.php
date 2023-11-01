<?php

namespace App\Repository;

use App\Entity\Book;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Book>
 *
 * @method Book|null find($id, $lockMode = null, $lockVersion = null)
 * @method Book|null findOneBy(array $criteria, array $orderBy = null)
 * @method Book[]    findAll()
 * @method Book[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class BookRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Book::class);
    }

//    /**
//     * @return Book[] Returns an array of Book objects
//     */

    public function findBookByDate()
    {
        return $this->createQueryBuilder('b')
            ->where('b.pubdate > :pubdate')
            ->setParameters([
                'pubdate' => '2023-01-01'
            ])
            ->orderBy('b.title', 'ASC')
            ->getQuery()
            ->getResult();
    }




    public function findBookbusuername($username)
    {
        return $this->createQueryBuilder('b')
            ->Join('b.author', 'a')
            ->andWhere('a.username = :username')
            ->andWhere('b.publicationDate  > :x')
            ->setParameter('x', '2023-01-01')
            ->setParameter('username', $username)
            ->getQuery()
            ->getResult();
    }
    public function findBookbyref($ref)
    {
        return $this->createQueryBuilder('b')
            ->where('b.ref = :ref')
            ->setParameter('ref', $ref)
            ->getQuery()
            ->getResult();

    }

    public function deleteBooksByRef($ref)
    {
        return  $this->createQueryBuilder('b')
            ->delete('App:Book','b')
            ->where('b.ref = :ref')
            ->setParameter('ref', $ref)
            ->getQuery()
            ->execute();
    }
    public function modifyBooksCategory()
    {
        return  $this->createQueryBuilder('b')
            ->update('App:Book', 'b')
            ->set('b.category', ':newCategory')
            ->where('b.category = :oldCategory')
            ->setParameter('newCategory', 'Romance')
            ->setParameter('oldCategory', 'Science-Fiction')
            ->getQuery()
            ->execute();
    }



//    public function findOneBySomeField($value): ?Book
//    {
//        return $this->createQueryBuilder('b')
//            ->andWhere('b.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
