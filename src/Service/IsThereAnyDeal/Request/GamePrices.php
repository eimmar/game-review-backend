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

class GamePrices implements RequestInterface
{
    /**
     * @var array
     */
    private $plains;

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
     * @var array|null
     */
    private $exclude;

    /**
     * @var int|null
     */
    private $added;

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
        return array_filter([
            'plains' => $this->plains,
            'region' => $this->region,
            'country' => $this->country,
            'shops' => implode(',', (array)$this->shops),
            'exclude' => implode(',', (array)$this->exclude),
            'added' => $this->added,
        ]);
    }
}