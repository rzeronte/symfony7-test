<?php

namespace App\SuDespacho\Domain\Product\ValueObject;

use App\Shared\ValueObject\FloatNotNullable;
use Assert\Assertion;
use Assert\AssertionFailedException;

class ProductPrice extends FloatNotNullable
{
    /** @throws AssertionFailedException */
    public static function from(float $value): self
    {
        Assertion::greaterThan($value, 0);

        return new self($value);
    }
}
