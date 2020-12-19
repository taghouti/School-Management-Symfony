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
    // equivalent de l execution de find all 
    public function getStudent()
    {
        $query= $this->getEntityManager()->createQuery("SELECT s  FROM App\Entity\Student s "); 
        return $query->getResult(); // va executer cette requete 
    }

    public function getNumberStudent()
    {
        $query= $this->getEntityManager()->createQuery("SELECT COUNT(s)  FROM App\Entity\Student s "); 
        return $query->getSingleScalarResult(); // getsingleaScalar ca renvoie le num soit 3 elements de la bdd 
    }

    public function OrderByEmail()
    {
       return  $this->getEntityManager()->createQuery("SELECT s  FROM App\Entity\Student s ORDER BY s.email ASC")->getResult(); 
    }

    public function OrderByEmailQb()
    {   // qb: query builder
       return  $this->createQueryBuilder("s")->orderBy("s.email", "ASC")->getQuery()->getResult(); 
       // ca permet donc de generer la requete sql 
       // meme si je ne sais pas manipuler les requetes sql je peux recuperer de la bdd
    }

    
    public function listStudentByClass($id)
    {  
    return $this->createQueryBuilder("s")->join("s.classroom", "c")->addSelect("c")->where(
    "c.id=:id")->setParameter("id", $id)->getQuery()->getResult(); 
    
    }
}
