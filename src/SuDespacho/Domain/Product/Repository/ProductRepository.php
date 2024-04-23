<?php

namespace App\SuDespacho\Domain\Product\Repository;

use App\SuDespacho\Domain\Product\Product;

interface ProductRepository
{
    public function save(Product $product): void;

    /**
     * @return array<Product> $items
     */
    public function search(?string $name, ?int $page, ?int $limit): array;

    public function searchCount(?string $name, ?int $page, ?int $limit): int;
}
