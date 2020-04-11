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
