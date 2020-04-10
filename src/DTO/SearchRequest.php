<?php

declare(strict_types=1);

/**
 * @copyright C UAB NFQ Technologies
 *
 * This Software is the property of NFQ Technologies
 * and is protected by copyright law – it is NOT Freeware.
 *
 * Any unauthorized use of this software without a valid license key
 * is a violation of the license agreement and will be prosecuted by
 * civil and criminal law.
 *
 * Contact UAB NFQ Technologies:
 * E-mail: info@nfq.lt
 * http://www.nfq.lt
 *
 */


namespace App\DTO;

class SearchRequest extends PaginationRequest
{
    private array $filters;

    private string $orderBy;

    private string $order;

    /**
     * @param int $page
     * @param int $totalResults
     * @param int $pageSize
     * @param array $filters
     * @param string|null $orderBy
     * @param string|null $order
     */
    public function __construct(int $page, int $totalResults, int $pageSize, array $filters, ?string $orderBy = null, ?string $order = null)
    {
        parent::__construct($page, $totalResults, $pageSize);
        $this->filters = $filters;
        $this->orderBy = $orderBy ? $orderBy : 'createdAt';
        $this->order = $order ? $order : 'DESC';
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
    public function getOrderBy(): string
    {
        return $this->orderBy;
    }

    /**
     * @return string
     */
    public function getOrder(): string
    {
        return $this->order;
    }

    public function filter(string $key)
    {
        return array_key_exists($key, $this->filters) ? $this->filters[$key] : null;
    }
}
