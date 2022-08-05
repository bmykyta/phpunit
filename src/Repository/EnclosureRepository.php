<?php

namespace App\Repository;

use App\Entity\Enclosure;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Enclosure>
 *
 * @method Enclosure|null find($id, $lockMode = null, $lockVersion = null)
 * @method Enclosure|null findOneBy(array $criteria, array $orderBy = null)
 * @method Enclosure[]    findAll()
 * @method Enclosure[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class EnclosureRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Enclosure::class);
    }

    public function add(Enclosure $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(Enclosure $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }
}