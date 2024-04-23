<?php

namespace App\SuDespacho\Domain\Product\ValueObject;

use Assert\Assertion;
use Assert\AssertionFailedException;

class ProductId
{
    protected string $value;

    /**
     * @throws AssertionFailedException
     */
    protected function __construct(string $value)
    {
        $this->setValue($value);
    }

    /** @throws AssertionFailedException */
    public static function from(string $value): self
    {
        return new self($value);
    }

    public function value(): string
    {
        return $this->value;
    }

    /**
     * @throws AssertionFailedException
     */
    private function setValue(string $value): void
    {
        Assertion::uuid($value, sprintf('%s must be a valid UUID.', (new \ReflectionClass($this))->getShortName()));

        $this->value = $value;
    }

    public function __toString()
    {
        return $this->value;
    }
}
