<?php

namespace App\SuDespacho\Domain\Product\ValueObject;

use App\Shared\ValueObject\StringNotBlank;
use Assert\AssertionFailedException;

class ProductName extends StringNotBlank
{
    protected string $FIELD = 'Name';

    /** @throws AssertionFailedException */
    public static function from(string $value): self
    {
        return new self($value);
    }
}
