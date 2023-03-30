<?php

namespace App\Repository;

use App\Entity\FormulaireDeContact;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<FormulaireDeContact>
 *
 * @method FormulaireDeContact|null find($id, $lockMode = null, $lockVersion = null)
 * @method FormulaireDeContact|null findOneBy(array $criteria, array $orderBy = null)
 * @method FormulaireDeContact[]    findAll()
 * @method FormulaireDeContact[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class FormulaireDeContactRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, FormulaireDeContact::class);
    }

    public function add(FormulaireDeContact $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(FormulaireDeContact $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

//    /**
//     * @return FormulaireDeContact[] Returns an array of FormulaireDeContact objects
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

//    public function findOneBySomeField($value): ?FormulaireDeContact
//    {
//        return $this->createQueryBuilder('f')
//            ->andWhere('f.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
