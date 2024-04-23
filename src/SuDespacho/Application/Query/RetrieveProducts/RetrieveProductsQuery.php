<?php

namespace App\SuDespacho\Application\Query\RetrieveProducts;

class RetrieveProductsQuery
{
    private const int DEFAULT_PAGE = 1;

    private const int DEFAULT_LIMIT = 100;

    private ?string $name;

    private int $page;

    private int $limit;

    public function __construct(?string $name, ?int $page = null, ?int $limit = null)
    {
        $this->name = $name;
        $this->page = $page ?? self::DEFAULT_PAGE;
        $this->limit = $limit ?? self::DEFAULT_LIMIT;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function getPage(): int
    {
        return $this->page;
    }

    public function getLimit(): int
    {
        return $this->limit;
    }
}
