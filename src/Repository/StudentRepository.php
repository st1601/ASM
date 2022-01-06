<?php

namespace App\Repository;

use App\Entity\Student;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Student|null find($id, $lockMode = null, $lockVersion = null)
 * @method Student|null findOneBy(array $criteria, array $orderBy = null)
 * @method Student[]    findAll()
 * @method Student[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class StudentRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Student::class);
    }

    // /**
    //  * @return Student[] Returns an array of Student objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('s')
            ->andWhere('s.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('s.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Student
    {
        return $this->createQueryBuilder('s')
            ->andWhere('s.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
    /**
     * @return Student[]
     */
    public function SortBirthdayAsc(){
        return $this->createQueryBuilder('student')
        ->orderBy('student.birthday','ASC')
        ->getQuery()
        ->getResult();
    }
    /**
     * @return Student[]
     */
    public function SortBirthdayDesc(){
        return $this->createQueryBuilder('student')
        ->orderBy('student.birthday','DESC')
        ->getQuery()
        ->getResult();
    }
    /**
     * @return Student[]
     */
    public function searchStudent($name) {
        return $this->createQueryBuilder('student')
        ->andWhere('student.name LIKE :name')
        ->setParameter('name', '%' . $name . '%')
        ->orderBy('student.name','asc')
        ->setMaxResults(5)
        ->getQuery()
        ->getResult();
    }
}
