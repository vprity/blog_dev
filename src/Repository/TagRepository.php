<?php

namespace App\Repository;

use App\Entity\Tag;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\Query;
use Doctrine\Persistence\ManagerRegistry;

/**
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

    /*
    public function findByGetArray($array)
    {
        $em = $this->getEntityManager();
        $dql = $em->createQuery("SELECT t.name FROM App\Entity\Tag t WHERE t.name IN (:names)")->setParameter('names', $array);

        return $dql->getResult(Query::HYDRATE_SCALAR);
    }
    */
}
