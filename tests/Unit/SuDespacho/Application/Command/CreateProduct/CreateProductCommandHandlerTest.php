<?php

namespace App\Tests\Unit\SuDespacho\Application\Command\CreateProduct;

use App\SuDespacho\Application\Command\CreateProduct\CreateProductCommand;
use App\SuDespacho\Application\Command\CreateProduct\CreateProductCommandHandler;
use App\SuDespacho\Infrastructure\InMemory\InMemoryProductRepository;
use Assert\AssertionFailedException;
use PHPUnit\Framework\TestCase;
use Symfony\Component\Uid\Uuid;

class CreateProductCommandHandlerTest extends TestCase
{
    private InMemoryProductRepository $productRepository;

    /**
     * @throws AssertionFailedException
     */
    public function testCreateProductWithEmptyBodyMustFail(): void
    {
        $this->expectException(\InvalidArgumentException::class);
        $command = new CreateProductCommand('', '', '', 0, 4);
        (new CreateProductCommandHandler($this->productRepository))($command);
    }

    /**
     * @throws AssertionFailedException
     */
    public function testCreateProductWithBadNameMustFail(): void
    {
        $this->expectException(\InvalidArgumentException::class);
        $command = new CreateProductCommand(Uuid::v4(), '', '', 0, 4);
        (new CreateProductCommandHandler($this->productRepository))($command);
    }

    /**
     * @throws AssertionFailedException
     */
    public function testCreateProductWithBadDescriptionMustFail(): void
    {
        $this->expectException(\InvalidArgumentException::class);
        $command = new CreateProductCommand(Uuid::v4(), 'Example name', 'Example desc.', 0, 0);
        (new CreateProductCommandHandler($this->productRepository))($command);
    }

    /**
     * @throws AssertionFailedException
     */
    public function testCreateProductWithBadPriceMustFail(): void
    {
        $this->expectException(\InvalidArgumentException::class);
        $command = new CreateProductCommand(Uuid::v4(), 'Example name', 'Example desc.', 0, 0);
        (new CreateProductCommandHandler($this->productRepository))($command);
    }

    /**
     * @throws AssertionFailedException
     */
    public function testCreateProductWithBadTaxRateMustFail(): void
    {
        $this->expectException(\InvalidArgumentException::class);
        $command = new CreateProductCommand(Uuid::v4(), 'Example name', 'Example desc.', 1, 0);
        (new CreateProductCommandHandler($this->productRepository))($command);
    }

    /**
     * @throws AssertionFailedException
     */
    public function testCreateProductWithGoodArgumentsMustSuccess(): void
    {
        $productsInitial = $this->productRepository->searchCount(null, null, null);

        $command = new CreateProductCommand(Uuid::v4(), 'Example name', 'Example desc.', 1, 4);
        (new CreateProductCommandHandler($this->productRepository))($command);

        $this->assertEquals($productsInitial + 1, $this->productRepository->searchCount(null, null, null));
    }

    protected function setUp(): void
    {
        $this->productRepository = new InMemoryProductRepository();
    }
}
