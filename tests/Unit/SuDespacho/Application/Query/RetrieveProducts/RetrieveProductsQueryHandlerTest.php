<?php

namespace App\Tests\Unit\SuDespacho\Application\Query\RetrieveProducts;

use App\SuDespacho\Application\Query\RetrieveProducts\RetrieveProductsQuery;
use App\SuDespacho\Application\Query\RetrieveProducts\RetrieveProductsQueryHandler;
use App\SuDespacho\Domain\Product\Product;
use App\SuDespacho\Domain\Product\ValueObject\ProductDescription;
use App\SuDespacho\Domain\Product\ValueObject\ProductId;
use App\SuDespacho\Domain\Product\ValueObject\ProductName;
use App\SuDespacho\Domain\Product\ValueObject\ProductPrice;
use App\SuDespacho\Domain\Product\ValueObject\ProductPriceWithTax;
use App\SuDespacho\Domain\Product\ValueObject\ProductTaxRate;
use App\SuDespacho\Infrastructure\InMemory\InMemoryProductRepository;
use Assert\AssertionFailedException;
use PHPUnit\Framework\TestCase;

class RetrieveProductsQueryHandlerTest extends TestCase
{
    private InMemoryProductRepository $productRepository;

    public function testRetrieveProductsWithEmptyDatabaseMustReturnEmptyData(): void
    {
        $query = new RetrieveProductsQuery(null, 1, 1);
        $handler = new RetrieveProductsQueryHandler($this->productRepository);
        $paginator = $handler->__invoke($query);

        $this->assertEquals(json_encode([
            'data' => [],
            'page' => 1,
            'numResults' => 0,
            'numPages' => 0,
            'limit' => 1,
        ]), json_encode($paginator->jsonSerialize()));
    }

    /**
     * @throws AssertionFailedException
     */
    public function testRetrieveProductsWithRecordsMustReturnIt(): void
    {
        $this->productRepository->save(
            Product::create(
                ProductId::from('d5c509a1-3e74-4daf-9626-55e0c2665957'),
                ProductName::from('Name'),
                ProductDescription::from('Description'),
                ProductPrice::from(100),
                ProductTaxRate::from(10),
                ProductPriceWithTax::from(
                    ProductPrice::from(100),
                    ProductTaxRate::from(10)
                )
            )
        );

        $query = new RetrieveProductsQuery(null, null, null);
        $handler = new RetrieveProductsQueryHandler($this->productRepository);
        $paginator = $handler->__invoke($query);

        $this->assertEquals(json_encode([
            'data' => [
                [
                    'id' => 'd5c509a1-3e74-4daf-9626-55e0c2665957',
                    'name' => 'Name',
                    'description' => 'Description',
                    'price' => 100.0,
                    'taxRate' => 10.0,
                    'priceWithTax' => 110.0,
                ],
            ],
            'page' => 1,
            'numResults' => 1,
            'numPages' => 1,
            'limit' => 100,
        ]), json_encode($paginator->jsonSerialize()));
    }

    protected function setUp(): void
    {
        $this->productRepository = new InMemoryProductRepository();
    }
}
