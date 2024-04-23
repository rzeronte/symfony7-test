<?php

namespace App\Shared\ValueObject;

use Assert\Assertion;
use Assert\AssertionFailedException;

class StringNotBlank
{
    protected string $FIELD = '_FIELD_NAME_';

    private string $value;

    /** @throws AssertionFailedException */
    public function __construct(string $value)
    {
        $this->setValue($value);
    }

    public function value(): string
    {
        return $this->value;
    }

    /** @throws AssertionFailedException */
    private function setValue(string $value): void
    {
        Assertion::notBlank($value, $this->FIELD.' cannot be empty');
        $this->value = $value;
    }

    public function __toString()
    {
        return $this->value;
    }
}
