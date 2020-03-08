<?php

declare(strict_types=1);




namespace App\Service\IGDB\DTO;

use App\Service\IGDB\Traits\TimestampableTrait;
use App\Service\IGDB\Traits\UrlIdentifiableTrait;
use App\Traits\IdentifiableTrait;

class Platform
{
    use TimestampableTrait;
    use UrlIdentifiableTrait;
    use IdentifiableTrait;

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
     * @param int $id
     * @param string|null $abbreviation
     * @param string|null $alternativeName
     * @param int|null $category
     * @param int|null $generation
     * @param int|null $platformLogo
     * @param int|null $productFamily
     * @param string|null $summary
     * @param int[]|null $versions
     * @param int[]|null $websites
     * @param string|null $name
     * @param string|null $url
     * @param string|null $slug
     * @param int|null $updatedAt
     * @param int|null $createdAt
     */
    public function __construct(
        int $id,
        ?string $abbreviation,
        ?string $alternativeName,
        ?int $category,
        ?int $generation,
        ?int $platformLogo,
        ?int $productFamily,
        ?string $summary,
        ?array $versions,
        ?array $websites,
        ?string $name,
        ?string $url,
        ?string  $slug,
        ?int $updatedAt,
        ?int $createdAt
    ) {
        $this->id = $id;
        $this->abbreviation = $abbreviation;
        $this->alternativeName = $alternativeName;
        $this->category = $category;
        $this->generation = $generation;
        $this->platformLogo = $platformLogo;
        $this->productFamily = $productFamily;
        $this->summary = $summary;
        $this->versions = $versions;
        $this->websites = $websites;
        $this->name = $name;
        $this->slug = $slug;
        $this->url = $url;
        $this->updatedAt = $updatedAt;
        $this->createdAt = $createdAt;
    }

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