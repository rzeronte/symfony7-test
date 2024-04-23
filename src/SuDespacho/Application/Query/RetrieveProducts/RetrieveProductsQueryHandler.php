<?php

namespace App\SuDespacho\Application\Query\RetrieveProducts;

use App\SuDespacho\Domain\Product\Repository\ProductRepository;

class RetrieveProductsQueryHandler
{
    private ProductRepository $productRepository;

    public function __construct(ProductRepository $productRepository)
    {
        $this->productRepository = $productRepository;
    }

    public function __invoke(RetrieveProductsQuery $query): RetrieveProductsResponse
    {
        return RetrieveProductsResponse::from(
            $this->productRepository->search($query->getName(), $query->getPage(), $query->getLimit()),
            $query->getPage(),
            $query->getLimit(),
            $this->productRepository->searchCount($query->getName(), $query->getPage(), $query->getLimit())
        );
    }
}
