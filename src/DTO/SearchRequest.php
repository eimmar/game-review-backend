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

    /**
     * @param int $page
     * @param int $totalResults
     * @param int $pageSize
     * @param array $filters
     */
    public function __construct(int $page, int $totalResults, int $pageSize, array $filters)
    {
        parent::__construct($page, $totalResults, $pageSize);
        $this->filters = $filters;
    }

    /**
     * @return array
     */
    public function getFilters(): array
    {
        return $this->filters;
    }
}
