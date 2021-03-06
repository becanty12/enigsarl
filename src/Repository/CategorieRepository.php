<?php

namespace App\Repository;

use App\Entity\Categorie;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Categorie|null find($id, $lockMode = null, $lockVersion = null)
 * @method Categorie|null findOneBy(array $criteria, array $orderBy = null)
 * @method Categorie[]    findAll()
 * @method Categorie[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CategorieRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Categorie::class);
    }

    public function affiche_produit($id)
    {
        $conn = $this->getEntityManager()
            ->getConnection();
        $sql = "
            SELECT *
            FROM produit p
            INNER JOIN image as i on i.produit_id=p.id
            WHERE p.`categorie_id`=:id 
           
            ";
        $stmt = $conn->prepare($sql);
        $stmt->execute(array('id' => $id));
        return $stmt->fetchAll();
    }

    public function affiche_produit_One($id)
    {
        $conn = $this->getEntityManager()
            ->getConnection();
        $sql = "
            SELECT *
            FROM produit p
            INNER JOIN image as i on i.produit_id=p.id
            WHERE p.id=:id 
           
            ";
        $stmt = $conn->prepare($sql);
        $stmt->execute(array('id' => $id));
        return $stmt->fetchAll();
    }

    public function listeCategorie()
    {
        $conn = $this->getEntityManager()
            ->getConnection();
        $sql = "
            SELECT c.`libelle`,c.`status`,c.`description`,p.`libelle`
            FROM `categorie` AS c 
            left JOIN `produit` AS p ON p.`categorie_id`=c.`id`
            GROUP BY c.`libelle`
            ";
        $stmt = $conn->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll();
    }
    // /**
    //  * @return Categorie[] Returns an array of Categorie objects
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
    public function findOneBySomeField($value): ?Categorie
    {
        return $this->createQueryBuilder('c')
            ->andWhere('c.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
