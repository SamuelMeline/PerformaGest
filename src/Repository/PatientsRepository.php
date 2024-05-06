<?php

namespace App\Repository;

use App\Entity\Patients;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Patients>
 *
 * @method Patients|null find($id, $lockMode = null, $lockVersion = null)
 * @method Patients|null findOneBy(array $criteria, array $orderBy = null)
 * @method Patients[]    findAll()
 * @method Patients[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class PatientsRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Patients::class);
    }


    /**
     * @param $category
     * @return Patients[]
     */
    public function PatientsByCategory($category): array
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.categorie = :category_id')
            ->setParameter('category_id', $category)
            ->getQuery()
            ->getResult();
    }

    /**
     * Undocumented function
     *
     * @param [type] $distributeur
     * @return array
     */
    public function PatientsByDistributeur($distributeur): array
    {
        return $this->createQueryBuilder('p')
            ->innerJoin('p.distributeur', 'd')
            ->andWhere('d.id = :distributeur_id')
            ->setParameter('distributeur_id', $distributeur)
            ->getQuery()
            ->getResult();
    }
}
