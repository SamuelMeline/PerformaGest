<?php 

namespace App\Repository;

use App\Entity\Patient;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Patient>
 */
class PatientRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Patient::class);
    }

    /**
     * @return Patient[] Returns an array of Patient objects
     */
    public function findByLetter(string $letter): array
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.lastName LIKE :letter')
            ->setParameter('letter', $letter . '%')
            ->orderBy('p.lastName', 'ASC')
            ->getQuery()
            ->getResult();
    }
}