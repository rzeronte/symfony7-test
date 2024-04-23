<?php

namespace App\SuDespacho\Infrastructure\InMemory;

use App\SuDespacho\Domain\Product\Product;
use App\SuDespacho\Domain\Product\Repository\ProductRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\Common\Collections\Criteria;

class InMemoryProductRepository implements ProductRepository
{
    /**
     * @var Collection<string, Product>
     */
    private Collection $products;

    /**
     * @param array<Product> $products
     */
    public function __construct(array $products = [])
    {
        $this->products = new ArrayCollection([]);

        foreach ($products as $product) {
            $this->save($product);
        }
    }

    public function save(Product $product): void
    {
        $this->products->set($product->id()->value(), $product);
    }

    public function search(?string $name, ?int $page, ?int $limit): array
    {
        $results = $this->products;
        $criteria = Criteria::create();

        return $results->matching($criteria)->toArray();
    }

    public function searchCount(?string $name, ?int $page, ?int $limit): int
    {
        $results = $this->products;

        $criteria = Criteria::create()
            ->setFirstResult(($page - 1) * $limit)
            ->setMaxResults($limit)
        ;

        return $results->matching($criteria)->count();
    }
}
