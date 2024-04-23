<?php

namespace App\SuDespacho\Application\Command\CreateProduct;

use App\SuDespacho\Domain\Product\Product;
use App\SuDespacho\Domain\Product\Repository\ProductRepository;
use App\SuDespacho\Domain\Product\ValueObject\ProductDescription;
use App\SuDespacho\Domain\Product\ValueObject\ProductId;
use App\SuDespacho\Domain\Product\ValueObject\ProductName;
use App\SuDespacho\Domain\Product\ValueObject\ProductPrice;
use App\SuDespacho\Domain\Product\ValueObject\ProductPriceWithTax;
use App\SuDespacho\Domain\Product\ValueObject\ProductTaxRate;
use Assert\AssertionFailedException;

class CreateProductCommandHandler
{
    private ProductRepository $productRepository;

    public function __construct(ProductRepository $productRepository)
    {
        $this->productRepository = $productRepository;
    }

    /**
     * @throws AssertionFailedException
     */
    public function __invoke(CreateProductCommand $command): void
    {
        $product = Product::create(
            ProductId::from($command->id()),
            ProductName::from($command->name()),
            ProductDescription::from($command->description()),
            ProductPrice::from($command->price()),
            ProductTaxRate::from($command->taxRate()),
            ProductPriceWithTax::from(
                ProductPrice::from($command->price()),
                ProductTaxRate::from($command->taxRate())
            )
        );

        $this->productRepository->save($product);
    }
}
