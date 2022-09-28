<?php

namespace App\Repository;

use App\Entity\Manga;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use phpDocumentor\Reflection\Types\String_;

/**
 * @extends ServiceEntityRepository<Manga>
 *
 * @method Manga|null find($id, $lockMode = null, $lockVersion = null)
 * @method Manga|null findOneBy(array $criteria, array $orderBy = null)
 * @method Manga[]    findAll()
 * @method Manga[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class MangaRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Manga::class);
    }

    public function add(Manga $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(Manga $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function findByLastChapterAdded(): array
    {
        return $this->createQueryBuilder('m')
            ->innerJoin('App\Entity\Chapter', 'c', 'WITH', 'c.manga = m.id')
            ->orderBy('c.date_uploads', 'DESC')
            ->getQuery()
            ->getResult();
    }

       public function search(string $searchedValue): array
       {
           return $this->createQueryBuilder('m')
               ->andWhere('m.title LIKE :val')
               ->setParameter(':val','%' . $searchedValue . '%')
               ->getQuery()
               ->getResult()
           ;
       }
}
