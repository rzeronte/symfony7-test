<?php

namespace App\SuDespacho\Infrastructure\Persistence\Doctrine\Repository;

use App\SuDespacho\Domain\Product\Product;
use App\SuDespacho\Domain\Product\Repository\ProductRepository;
use Doctrine\Common\Collections\Criteria;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\Query\QueryException;

class DoctrineProductRepository implements ProductRepository
{
    private EntityManagerInterface $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    public function save(Product $product): void
    {
        $this->entityManager->persist($product);
        $this->entityManager->flush();
    }

    /**
     * @throws QueryException
     */
    public function search(?string $name, ?int $page, ?int $limit): array
    {
        $queryBuilder = $this->entityManager->createQueryBuilder()
            ->select('c')
            ->from(Product::class, 'c');

        if (null !== $name) {
            $queryBuilder->andWhere($queryBuilder->expr()->like('c.name', ':name'))
                ->setParameter('name', '%'.$name.'%');
        }

        $criteria = Criteria::create()->setFirstResult(($page - 1) * $limit)->setMaxResults($limit);

        return $queryBuilder->addCriteria($criteria)
            ->getQuery()
            ->getResult();
    }

    public function searchCount(?string $name, ?int $page, ?int $limit): int
    {
        $queryBuilder = $this->entityManager->createQueryBuilder()
            ->select('count(c.id)')
            ->from(Product::class, 'c');

        if (null !== $name) {
            $queryBuilder->andWhere($queryBuilder->expr()->like('c.name', ':name'))
                ->setParameter('name', '%'.$name.'%');
        }

        return (int) $queryBuilder->getQuery()
            ->getSingleScalarResult();
    }
}
