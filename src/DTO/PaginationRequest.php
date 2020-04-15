<?php

declare(strict_types=1);

namespace App\DTO;

class PaginationRequest
{
    private int $page;

    private int $pageSize;

    /**
     * @param int $page
     * @param int $pageSize
     */
    public function __construct(int $page, int $pageSize)
    {
        $this->page = $page;
        $this->pageSize = $pageSize;
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

    public function getFirstResult()
    {
        return $this->getPageSize() * ($this->getPage() - 1);
    }
}
