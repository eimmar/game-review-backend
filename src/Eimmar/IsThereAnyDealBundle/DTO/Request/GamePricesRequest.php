<?php

declare(strict_types=1);

namespace App\Eimmar\IsThereAnyDealBundle\DTO\Request;

class GamePricesRequest implements RequestInterface
{
    /**
     * @var array
     */
    private array $plains;

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
     * @var array|null
     */
    private ?array $exclude;

    /**
     * @var int|null
     */
    private ?int $added;

    /**
     * @param array $plains
     * @param string|null $region
     * @param string|null $country
     * @param array|null $shops
     * @param array|null $exclude
     * @param int|null $added
     */
    public function __construct(
        array $plains,
        ?string $region = null,
        ?string $country = null,
        ?array $shops = null,
        ?array $exclude = null,
        ?int $added = null
    ) {
        $this->plains = $plains;
        $this->region = $region;
        $this->country = $country;
        $this->shops = $shops;
        $this->exclude = $exclude;
        $this->added = $added;
    }

    /**
     * @inheritDoc
     */
    public function unwrap(): array
    {
        return array_filter(
            [
                'plains' => implode(',', (array)$this->plains),
                'region' => $this->region,
                'country' => $this->country,
                'shops' => implode(',', (array)$this->shops),
                'exclude' => implode(',', (array)$this->exclude),
                'added' => $this->added,
            ],
            function ($item) {
                return strlen(trim((string)$item)) !== 0;
            }
        );
    }

    public function getCacheKey(): string
    {
        return 'isThereAnyDeal.gamePrices.' . str_replace(['{', '}', '(',')','/','\\','@', ':', ' '], '', implode('', $this->unwrap()));
    }
}
