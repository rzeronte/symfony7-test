<?php

namespace App\SuDespacho\Domain\Product\ValueObject;

use App\Shared\ValueObject\StringNotBlank;
use Assert\AssertionFailedException;

class ProductDescription extends StringNotBlank
{
    protected string $FIELD = 'Description';

    /** @throws AssertionFailedException */
    public static function from(string $value): self
    {
        return new self($value);
    }
}
