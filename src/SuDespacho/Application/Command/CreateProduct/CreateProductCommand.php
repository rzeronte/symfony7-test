<?php

namespace App\SuDespacho\Application\Command\CreateProduct;

class CreateProductCommand
{
    private string $id;
    private string $name;

    private string $description;

    private float $price;
    private float $taxRate;

    public function __construct(
        string $id,
        string $name,
        string $description,
        float $price,
        float $taxRate
    ) {
        $this->id = $id;
        $this->name = $name;
        $this->description = $description;
        $this->price = $price;
        $this->taxRate = $taxRate;
    }

    public function id(): string
    {
        return $this->id;
    }

    public function name(): string
    {
        return $this->name;
    }

    public function description(): string
    {
        return $this->description;
    }

    public function price(): float
    {
        return $this->price;
    }

    public function taxRate(): float
    {
        return $this->taxRate;
    }
}
