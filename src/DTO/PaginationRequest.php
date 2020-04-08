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

class PaginationRequest
{
    private int $page;

    private int $totalResults;

    private int $pageSize;

    /**
     * @param int $page
     * @param int $totalResults
     * @param int $pageSize
     */
    public function __construct(int $page, int $totalResults, int $pageSize)
    {
        $this->page = $page;
        $this->totalResults = $totalResults;
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
    public function getTotalResults(): int
    {
        return $this->totalResults;
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
