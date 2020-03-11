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


namespace App\Eimmar\GameSpotBundle\DTO\Review;

use App\Eimmar\GameSpotBundle\DTO\DTO;

class Release implements DTO
{
    /**
     * @var string|null
     */
    private ?string $upc;

    /**
     * @var string
     */
    private string $distributionType;

    /**
     * @var int
     */
    private int $id;

    /**
     * @var string
     */
    private string $name;

    /**
     * @var string
     */
    private string $region;

    /**
     * @var string
     */
    private string $platform;

    /**
     * @var string
     */
    private string $apiDetailUrl;

    /**
     * @param string|null $upc
     * @param string $distributionType
     * @param int $id
     * @param string $name
     * @param string $region
     * @param string $platform
     * @param string $apiDetailUrl
     */
    public function __construct(
        ?string $upc,
        string $distributionType,
        int $id,
        string $name,
        string $region,
        string $platform,
        string $apiDetailUrl
    ) {
        $this->upc = $upc;
        $this->distributionType = $distributionType;
        $this->id = $id;
        $this->name = $name;
        $this->region = $region;
        $this->platform = $platform;
        $this->apiDetailUrl = $apiDetailUrl;
    }

    /**
     * @return string|null
     */
    public function getUpc(): ?string
    {
        return $this->upc;
    }

    /**
     * @return string
     */
    public function getDistributionType(): string
    {
        return $this->distributionType;
    }

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @return string
     */
    public function getRegion(): string
    {
        return $this->region;
    }

    /**
     * @return string
     */
    public function getPlatform(): string
    {
        return $this->platform;
    }

    /**
     * @return string
     */
    public function getApiDetailUrl(): string
    {
        return $this->apiDetailUrl;
    }
}
