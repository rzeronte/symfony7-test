<?php

namespace App\Tests\Unit\SuDespacho\Domain\Product;

use App\SuDespacho\Domain\Product\Product;
use App\SuDespacho\Domain\Product\ValueObject\ProductDescription;
use App\SuDespacho\Domain\Product\ValueObject\ProductId;
use App\SuDespacho\Domain\Product\ValueObject\ProductName;
use App\SuDespacho\Domain\Product\ValueObject\ProductPrice;
use App\SuDespacho\Domain\Product\ValueObject\ProductPriceWithTax;
use App\SuDespacho\Domain\Product\ValueObject\ProductTaxRate;
use Assert\AssertionFailedException;
use PHPUnit\Framework\TestCase;

class ProductTest extends TestCase
{
    /**
     * @throws AssertionFailedException
     */
    public function testCreateProduct(): void
    {
        $product = Product::create(
            ProductId::from('2ee49aa0-b085-4376-9bcd-a962aead4fc6'),
            ProductName::from('Name'),
            ProductDescription::from('Description'),
            ProductPrice::from(100),
            ProductTaxRate::from(4),
            ProductPriceWithTax::from(
                ProductPrice::from(100),
                ProductTaxRate::from(10)
            )
        );

        $this->assertEquals('2ee49aa0-b085-4376-9bcd-a962aead4fc6', $product->id()->value());
        $this->assertEquals('2ee49aa0-b085-4376-9bcd-a962aead4fc6', $product->id());
        $this->assertEquals('Name', $product->name()->value());
        $this->assertEquals('Name', $product->name());
        $this->assertEquals('Description', $product->description()->value());
        $this->assertEquals('Description', $product->description());
        $this->assertEquals(4, $product->taxRate()->value());
        $this->assertEquals(110, $product->priceWithTax()->value());
    }

    /**
     * @throws AssertionFailedException
     */
    public function testCreateProductDirectPriceWithTax(): void
    {
        $product = Product::create(
            ProductId::from('2ee49aa0-b085-4376-9bcd-a962aead4fc6'),
            ProductName::from('Name'),
            ProductDescription::from('Description'),
            ProductPrice::from(100),
            ProductTaxRate::from(4),
            ProductPriceWithTax::fromValue(110)
        );

        $this->assertEquals('2ee49aa0-b085-4376-9bcd-a962aead4fc6', $product->id()->value());
        $this->assertEquals('2ee49aa0-b085-4376-9bcd-a962aead4fc6', $product->id());
        $this->assertEquals('Name', $product->name()->value());
        $this->assertEquals('Name', $product->name());
        $this->assertEquals('Description', $product->description()->value());
        $this->assertEquals('Description', $product->description());
        $this->assertEquals(4, $product->taxRate()->value());
        $this->assertEquals(110, $product->priceWithTax()->value());
    }
}
