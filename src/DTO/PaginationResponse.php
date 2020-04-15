<?php

declare(strict_types=1);

namespace App\DTO;

class PaginationResponse extends PaginationRequest
{
    private int $totalResults;

    private array $items;

    /**
     * @param int $page
     * @param int $totalResults
     * @param int $pageSize
     * @param array $items
     */
    public function __construct(int $page, int $totalResults, int $pageSize, array $items)
    {
        parent::__construct($page, $pageSize);
        $this->items = $items;
        $this->totalResults = $totalResults;
    }

    /**
     * @return array
     */
    public function getItems(): array
    {
        return $this->items;
    }

    /**
     * @return int
     */
    public function getTotalResults(): int
    {
        return $this->totalResults;
    }
}
