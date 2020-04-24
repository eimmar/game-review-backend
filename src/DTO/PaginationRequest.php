<?php

declare(strict_types=1);

namespace App\DTO;

class PaginationRequest
{
    private int $page;

    private int $pageSize;

    private ?int $firstResult;

    /**
     * @param int $page
     * @param int $pageSize
     * @param int|null $firstResult
     */
    public function __construct(int $page, int $pageSize, ?int $firstResult = null)
    {
        $this->page = $page;
        $this->pageSize = $pageSize;
        $this->firstResult = $firstResult;
    }

    /**
     * @return int
     */
    public function getPage(): int
    {
        return $this->page;
    }

    /**
     * @return int
     */
    public function getPageSize(): int
    {
        return $this->pageSize;
    }

    public function getFirstResult(): int
    {
        return $this->firstResult ?? $this->getPageSize() * ($this->getPage() - 1);
    }
}
