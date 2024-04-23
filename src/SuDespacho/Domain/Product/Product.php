<?php

namespace App\SuDespacho\Domain\Product;

use App\SuDespacho\Domain\Product\ValueObject\ProductDescription;
use App\SuDespacho\Domain\Product\ValueObject\ProductId;
use App\SuDespacho\Domain\Product\ValueObject\ProductName;
use App\SuDespacho\Domain\Product\ValueObject\ProductPrice;
use App\SuDespacho\Domain\Product\ValueObject\ProductPriceWithTax;
use App\SuDespacho\Domain\Product\ValueObject\ProductTaxRate;

class Product implements \JsonSerializable
{
    private ProductId $id;
    private ProductName $name;

    private ProductDescription $description;

    private ProductPrice $price;

    private ProductTaxRate $taxRate;

    private ProductPriceWithTax $priceWithTax;

    private function __construct(
        ProductId $id,
        ProductName $name,
        ProductDescription $description,
        ProductPrice $price,
        ProductTaxRate $tax,
        ProductPriceWithTax $priceWithTax
    ) {
        $this->id = $id;
        $this->name = $name;
        $this->description = $description;
        $this->price = $price;
        $this->taxRate = $tax;
        $this->priceWithTax = $priceWithTax;
    }

    public static function create(
        ProductId $id,
        ProductName $name,
        ProductDescription $description,
        ProductPrice $price,
        ProductTaxRate $tax,
        ProductPriceWithTax $priceWithTax
    ): Product {
        return new self($id, $name, $description, $price, $tax, $priceWithTax);
    }

    public function id(): ProductId
    {
        return $this->id;
    }

    public function name(): ProductName
    {
        return $this->name;
    }

    public function description(): ProductDescription
    {
        return $this->description;
    }

    public function price(): ProductPrice
    {
        return $this->price;
    }

    public function taxRate(): ProductTaxRate
    {
        return $this->taxRate;
    }

    public function priceWithTax(): ProductPriceWithTax
    {
        return $this->priceWithTax;
    }

    /**
     * @return array<string, mixed> $products
     */
    public function jsonSerialize(): array
    {
        return [
            'id' => $this->id()->value(),
            'name' => $this->name()->value(),
            'description' => $this->description()->value(),
            'price' => $this->price()->value(),
            'taxRate' => $this->taxRate()->value(),
            'priceWithTax' => $this->priceWithTax()->value(),
        ];
    }
}
