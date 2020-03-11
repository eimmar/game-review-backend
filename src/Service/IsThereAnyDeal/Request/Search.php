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


namespace App\Service\IsThereAnyDeal\Request;


class Search implements RequestInterface
{
    /**
     * @var string
     */
    private $query;

    /**
     * @var int|null
     */
    private $offset;

    /**
     * @var int|null
     */
    private $limit;

    /**
     * @var string|null
     */
    private $region;

    /**
     * @var string|null
     */
    private $country;

    /**
     * @var array|null
     */
    private $shops;

    /**
     * @param string $query
     * @param int|null $offset
     * @param int|null $limit
     * @param string|null $region
     * @param string|null $country
     * @param array|null $shops
     */
    public function __construct(
        string $query,
        ?int $offset = null,
        ?int $limit = null,
        ?string $region = null,
        ?string $country = null,
        ?array $shops = null
    ) {
        $this->query = $query;
        $this->offset = $offset;
        $this->limit = $limit;
        $this->region = $region;
        $this->country = $country;
        $this->shops = $shops;
    }

    /**
     * @return array
     */
    public function unwrap(): array
    {
        return array_filter([
            'q' => $this->query,
            'offset' => $this->offset,
            'limit' => $this->limit,
            'region' => $this->region,
            'country' => $this->country,
            'shops' => implode(',', (array)$this->shops),
        ]);
    }
}
