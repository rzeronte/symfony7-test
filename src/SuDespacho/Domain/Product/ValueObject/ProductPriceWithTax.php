<?php

namespace App\SuDespacho\Domain\Product\ValueObject;

use App\Shared\ValueObject\FloatNotNullable;

class ProductPriceWithTax extends FloatNotNullable
{
    public static function from(ProductPrice $price, ProductTaxRate $taxRate): self
    {
        return new self($price->value() + ($price->value() * ($taxRate->value() / 100)));
    }

    public static function fromValue(float $value): self
    {
        return new self($value);
    }
}
