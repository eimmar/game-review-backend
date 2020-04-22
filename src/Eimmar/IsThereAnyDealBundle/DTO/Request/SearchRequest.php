<?php

declare(strict_types=1);

namespace App\Eimmar\IsThereAnyDealBundle\DTO\Request;


class SearchRequest implements RequestInterface
{
    /**
     * @var string
     */
    private string $query;

    /**
     * @var int|null
     */
    private ?int $offset;

    /**
     * @var int|null
     */
    private ?int $limit;

    /**
     * @var string|null
     */
    private ?string $region;

    /**
     * @var string|null
     */
    private ?string $country;

    /**
     * @var array|null
     */
    private ?array $shops;

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
        return array_filter(
            [
                'q' => urldecode($this->query),
                'offset' => $this->offset,
                'limit' => $this->limit,
                'region' => $this->region,
                'country' => $this->country,
                'shops' => implode(',', (array)$this->shops),
            ],
            function ($item) {
                return strlen(trim((string)$item)) !== 0;
            }
        );
    }

    public function getCacheKey(): string
    {
        return 'isThereAnyDeal.search.' . str_replace(['{', '}', '(',')','/','\\','@', ':', ' '], '', implode('', $this->unwrap()));
    }
}
