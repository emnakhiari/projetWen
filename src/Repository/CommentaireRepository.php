<?php

namespace App\Repository;

use App\Entity\Commentaire;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Commentaire>
 *
 * @method Commentaire|null find($id, $lockMode = null, $lockVersion = null)
 * @method Commentaire|null findOneBy(array $criteria, array $orderBy = null)
 * @method Commentaire[]    findAll()
 * @method Commentaire[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CommentaireRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Commentaire::class); 
        
    }

    public function save(Commentaire $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(Commentaire $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function findByIdUser($idUtilisateur){
       $entityManager = $this->getEntityManager();
       $query=$entityManager
       ->createQuery("SELECT c FROM App\Entity\Commentaire c WHERE c.idUtilisateur = :idUtilisateur")
       ->setParameter('idUtilisateur',$idUtilisateur);
       return $query->getResult();
    }

    public function findTypeStartwithP(){
        $entityManager = $this->getEntityManager();
        $query=$entityManager
        ->createQuery("SELECT c FROM App\Entity\Commentaire c WHERE c.type like :type")
        ->setParameter('type','P%');
        return $query->getResult();
     }
     
     public function countByCommentaireIsSignaler($id) {
        $entityManager = $this->getEntityManager();
        $query = $entityManager
            ->createQuery("SELECT COUNT(c) FROM App\Entity\Commentaire c WHERE c.commentaire LIKE :comment AND c.idUtilisateur = :id")
            ->setParameter('id', $id)
            ->setParameter('comment', 'Signaler');
        return $query->getSingleScalarResult();
    }
    public function countByArticleIsSignaler($id) {
        $entityManager = $this->getEntityManager();
        $query = $entityManager
            ->createQuery("SELECT COUNT(c) FROM App\Entity\Commentaire c WHERE c.commentaire LIKE :comment AND c.idproduit = :id")
            ->setParameter('id', $id)
            ->setParameter('comment', 'Signaler');
        return $query->getSingleScalarResult();
    }
    


     public function findOneById($id)
     {
         $entityManager = $this->getEntityManager();
     
         $query = $entityManager->createQuery('SELECT c FROM App\Entity\Commentaire c WHERE c.id = :id')
         ->setParameter('id', $id);
     
         $commentaire = $query->getOneOrNullResult();
     
         return $commentaire;
     }
     public function findOneByIdComm($id)
     {
         $entityManager = $this->getEntityManager();
     
         $query = $entityManager->createQuery('SELECT c.idUtilisateur FROM App\Entity\Commentaire c WHERE c.id = :id')
         ->setParameter('id', $id);
     
         $iduser = $query->getOneOrNullResult();
     
         return $iduser;
     }

     public function findOneEmailByIdArticle($id)
     {
         $entityManager = $this->getEntityManager();
     
         $query = $entityManager->createQuery('SELECT u.email FROM App\Entity\utilisateur u WHERE c.idproduit = :id')
         ->setParameter('id', $id);
     
         $iduser = $query->getOneOrNullResult();
     
         return $iduser;
     }
    public function countCommentaire($idUtilisateur){
        $entityManager = $this->getEntityManager();
        $query=$entityManager
        ->createQuery("SELECT count(c) FROM App\Entity\Commentaire c WHERE c.idUtilisateur = :idUtilisateur")
        ->setParameter('idUtilisateur',$idUtilisateur);
        return $query->getSingleScalarResult();
    }
    public function countCommentaireArticle($id){
        $entityManager = $this->getEntityManager();
        $query=$entityManager
        ->createQuery("SELECT count(c) FROM App\Entity\Commentaire c WHERE c.idproduit = :idproduit")
        ->setParameter('idproduit',$id);
        return $query->getSingleScalarResult();
    }


//    /**
//     * @return Commentaire[] Returns an array of Commentaire objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('c')
//            ->andWhere('c.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('c.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?Commentaire
//    {
//        return $this->createQueryBuilder('c')
//            ->andWhere('c.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
