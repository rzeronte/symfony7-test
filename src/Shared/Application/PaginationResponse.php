<?php

namespace App\Shared\Application;

use App\SuDespacho\Domain\Product\Product;

class PaginationResponse implements \JsonSerializable
{
    /** @phpstan-ignore-next-line */
    private array $results;
    private int $page;
    private int $limit;
    private int $numResults;

    /** @phpstan-ignore-next-line */
    protected function __construct(array $results, int $page, int $limit, int $numResults)
    {
        $this->results = array_values($results);
        $this->page = $page;
        $this->limit = $limit;
        $this->numResults = $numResults;
    }

    /**
     * @return array<Product> $products
     */
    protected function results(): array
    {
        return $this->results;
    }

    public function page(): int
    {
        return $this->page;
    }

    public function limit(): int
    {
        return $this->limit;
    }

    public function numResults(): int
    {
        return $this->numResults;
    }

    public function numPages(): int
    {
        return (int) ceil($this->numResults / $this->limit);
    }

    /**
     * @return array<string, mixed> $products
     */
    public function jsonSerialize(): array
    {
        return [
            'data' => $this->results(),
            'page' => $this->page(),
            'numResults' => $this->numResults(),
            'numPages' => $this->numPages(),
            'limit' => $this->limit(),
        ];
    }
}
