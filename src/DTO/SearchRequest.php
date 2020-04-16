<?php

declare(strict_types=1);

namespace App\DTO;

class SearchRequest extends PaginationRequest
{
    private array $filters;

    private ?string $orderBy;

    private ?string $order;

    /**
     * @param int $page
     * @param int $pageSize
     * @param array $filters
     * @param string|null $orderBy
     * @param string|null $order
     */
    public function __construct(int $page, int $pageSize, array $filters, ?string $orderBy = null, ?string $order = null)
    {
        parent::__construct($page, $pageSize);
        $this->filters = $filters;
        $this->orderBy = $orderBy;
        $this->order = $order;
    }

    /**
     * @return array
     */
    public function getFilters(): array
    {
        return $this->filters;
    }

    /**
     * @return string
     */
    public function getOrderBy(): ?string
    {
        return $this->orderBy;
    }

    /**
     * @return string
     */
    public function getOrder(): ?string
    {
        return $this->order;
    }

    public function getFilter(string $key)
    {
        return array_key_exists($key, $this->filters) ? $this->filters[$key] : null;
    }
}
