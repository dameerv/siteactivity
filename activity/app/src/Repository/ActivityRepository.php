<?php

namespace App\Repository;

use App\Entity\Activity;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\DBAL\Exception;
use Doctrine\DBAL\Exception\DatabaseObjectNotFoundException;
use Doctrine\ORM\OptimisticLockException;
use Doctrine\ORM\ORMException;
use Doctrine\Persistence\ManagerRegistry;
use Knp\Component\Pager\PaginatorInterface;
use  \Knp\Component\Pager\Pagination\PaginationInterface;

/**
 * @method Activity|null find($id, $lockMode = null, $lockVersion = null)
 * @method Activity|null findOneBy(array $criteria, array $orderBy = null)
 * @method Activity[]    findAll()
 * @method Activity[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ActivityRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry, private PaginatorInterface $paginator)
    {
        parent::__construct($registry, Activity::class);
    }

    /**
     * @param int $page
     * @param int $itemsPerPage
     * @return PaginationInterface
     */
    public function getAllUrlsWithLastVisitPagination(int $page = 1, int $itemsPerPage = 10): PaginationInterface
    {
        $firstResult = $page * $itemsPerPage - $itemsPerPage;
        $query = $this->createQueryBuilder('a')
            ->select('a.url, max(a.visitedAt) as lastVisit, count(a.url) as numberOfVisits')
            ->groupBy('a.url')
            ->setFirstResult($firstResult)
            ->setMaxResults($itemsPerPage)
            ->getQuery();

        $pagination = $this->paginator->paginate($query, $page, $itemsPerPage);

        $result = $query->getResult();

        $pagination->setItems($result);

        $totalCount = $this->getTotalUrlsCount() ?: 0;
        $pagination->setTotalItemCount($totalCount);

        return $pagination;
    }

    /**
     * @return int|null
     */
    public function getTotalUrlsCount(): ?int
    {
        $totalCount = $this
            ->createQueryBuilder('t')
            ->select('count(distinct t.url) as totalCount')
            ->getQuery()
            ->getResult();

        if (count($totalCount) && isset($totalCount[0]['totalCount'])) {
            return $totalCount[0]['totalCount'];
        }

        return null;
    }

    /**
     * @throws ORMException
     * @throws OptimisticLockException
     */
    public function add(Activity $entity, bool $flush = true): void
    {
        $this->_em->persist($entity);
        if ($flush) {
            $this->_em->flush();
        }
    }

    /**
     * @throws ORMException
     * @throws OptimisticLockException
     */
    public function remove(Activity $entity, bool $flush = true): void
    {
        $this->_em->remove($entity);
        if ($flush) {
            $this->_em->flush();
        }
    }


    // /**
    //  * @return Activity[] Returns an array of Activity objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('a')
            ->andWhere('a.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('a.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Activity
    {
        return $this->createQueryBuilder('a')
            ->andWhere('a.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
