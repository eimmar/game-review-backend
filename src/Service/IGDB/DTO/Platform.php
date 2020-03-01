<?php

declare(strict_types=1);




namespace App\Service\IGDB\DTO;

use App\Service\IGDB\Traits\TimestampableTrait;
use App\Service\IGDB\Traits\UrlIdentifiableTrait;

class Platform
{
    use TimestampableTrait;
    use UrlIdentifiableTrait;

    /**
     * @var string|null
     */
    private $abbreviation;

    /**
     * @var string|null
     */
    private $alternativeName;

    /**
     * @var int|null
     */
    private $category;

    /**
     * @var int|null
     */
    private $generation;

    /**
     * @var int|null
     */
    private $platformLogo;

    /**
     * @var int|null
     */
    private $productFamily;

    /**
     * @var string|null
     */
    private $summary;

    /**
     * @var int[]|null
     */
    private $versions;

    /**
     * @var int[]|null
     */
    private $websites;

    /**
     * @return string|null
     */
    public function getAbbreviation(): ?string
    {
        return $this->abbreviation;
    }

    /**
     * @return string|null
     */
    public function getAlternativeName(): ?string
    {
        return $this->alternativeName;
    }

    /**
     * @return int|null
     */
    public function getCategory(): ?int
    {
        return $this->category;
    }

    /**
     * @return int|null
     */
    public function getGeneration(): ?int
    {
        return $this->generation;
    }

    /**
     * @return int|null
     */
    public function getPlatformLogo(): ?int
    {
        return $this->platformLogo;
    }

    /**
     * @return int|null
     */
    public function getProductFamily(): ?int
    {
        return $this->productFamily;
    }

    /**
     * @return string|null
     */
    public function getSummary(): ?string
    {
        return $this->summary;
    }

    /**
     * @return int[]|null
     */
    public function getVersions(): ?array
    {
        return $this->versions;
    }

    /**
     * @return int[]|null
     */
    public function getWebsites(): ?array
    {
        return $this->websites;
    }
}