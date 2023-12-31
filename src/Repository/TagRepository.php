<?php

namespace App\Repository;

use App\Entity\Tag;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Tag>
 *
 * @method Tag|null find($id, $lockMode = null, $lockVersion = null)
 * @method Tag|null findOneBy(array $criteria, array $orderBy = null)
 * @method Tag[]    findAll()
 * @method Tag[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class TagRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Tag::class);
    }

    public function findAllGreaterThanPrice(float $price):array
    {
        $em=$this->getEntityManager();
        $query=$em->createQuery(
            'SELECT p
            FROM App\Entity\Tag p
            ');
        return $query->getResult();
    }

    public function findAllTags():array
    {
        return $this->createQueryBuilder('t')
            ->orderBy('t.name', 'ASC')
            ->getQuery()
            ->getResult();

    }
}
