<?php

namespace App\SuDespacho\Application\Query\RetrieveProducts;

use App\Shared\Application\PaginationResponse;
use App\SuDespacho\Domain\Product\Product;

class RetrieveProductsResponse extends PaginationResponse
{
    /**
     * @param array<Product> $results
     */
    private function __construct(array $results, int $page, int $limit, int $numResults)
    {
        parent::__construct($results, $page, $limit, $numResults);
    }

    /**
     * @param array<Product> $results
     */
    public static function from(array $results, int $page, int $limit, int $numResults): self
    {
        return new self($results, $page, $limit, $numResults);
    }
}
