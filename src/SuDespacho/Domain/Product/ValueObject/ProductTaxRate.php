<?php

namespace App\SuDespacho\Domain\Product\ValueObject;

use App\Shared\ValueObject\FloatNotNullable;
use Assert\Assertion;
use Assert\AssertionFailedException;

class ProductTaxRate extends FloatNotNullable
{
    /** @throws AssertionFailedException */
    public static function from(float $value): self
    {
        Assertion::choice($value, [4.0, 10.0, 21.0]);

        return new self($value);
    }
}
