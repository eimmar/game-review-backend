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


namespace App\Service\IGDB\DTO;

use App\Service\IGDB\DTO\Company\Website;
use App\Service\IGDB\Traits\TimestampableTrait;
use App\Service\IGDB\Traits\UrlIdentifiableTrait;
use App\Traits\IdentifiableTrait;

class Company implements ResponseDTO
{
    use TimestampableTrait;
    use UrlIdentifiableTrait;
    use IdentifiableTrait;

    /**
     * @var int|null
     */
    private ?int $changeDate;

    /**
     * @var int|null
     */
    private ?int $changeDateCategory;

    /**
     * @var Company|int|null
     */
    private $changedCompanyId;

    /**
     * @var int|null
     */
    private ?int $country;

    /**
     * @var string|null
     */
    private ?string $description;

    /**
     * @var int|null
     */
    private ?int $logo;

    /**
     * @var Company|int|null
     */
    private $parent;

    /**
     * @var Game[]|int[]|null
     */
    private ?array $published;

    /**
     * @var int|null
     */
    private ?int $startDate;

    /**
     * @var Website[]|int[]|null
     */
    private ?array $websites;

    /**
     * @param int $id
     * @param int|null $changeDate
     * @param int|null $changeDateCategory
     * @param Company|int|null $changedCompanyId
     * @param int|null $country
     * @param string|null $description
     * @param int|null $logo
     * @param Company|int|null $parent
     * @param Game[]|int[]|null $published
     * @param int|null $startDate
     * @param Website[]|int[]|null $websites
     * @param string|null $name
     * @param string|null $url
     * @param string|null $slug
     * @param int|null $updatedAt
     * @param int|null $createdAt
     */
    public function __construct(
        int $id,
        ?int $changeDate,
        ?int $changeDateCategory,
        $changedCompanyId,
        ?int $country,
        ?string $description,
        ?int $logo,
        $parent,
        $published,
        ?int $startDate,
        $websites,
        ?string $name,
        ?string $url,
        ?string $slug,
        ?int $updatedAt,
        ?int $createdAt
    ) {
        $this->id = $id;
        $this->changeDate = $changeDate;
        $this->changeDateCategory = $changeDateCategory;
        $this->changedCompanyId = $changedCompanyId;
        $this->country = $country;
        $this->description = $description;
        $this->logo = $logo;
        $this->parent = $parent;
        $this->published = $published;
        $this->startDate = $startDate;
        $this->websites = $websites;
        $this->name = $name;
        $this->slug = $slug;
        $this->url = $url;
        $this->updatedAt = $updatedAt;
        $this->createdAt = $createdAt;
    }

    /**
     * @return int|null
     */
    public function getChangeDate(): ?int
    {
        return $this->changeDate;
    }

    /**
     * @return int|null
     */
    public function getChangeDateCategory(): ?int
    {
        return $this->changeDateCategory;
    }

    /**
     * @return Company|int|null
     */
    public function getChangedCompanyId()
    {
        return $this->changedCompanyId;
    }

    /**
     * @return int|null
     */
    public function getCountry(): ?int
    {
        return $this->country;
    }

    /**
     * @return string|null
     */
    public function getDescription(): ?string
    {
        return $this->description;
    }

    /**
     * @return int|null
     */
    public function getLogo(): ?int
    {
        return $this->logo;
    }

    /**
     * @return Company|int|null
     */
    public function getParent()
    {
        return $this->parent;
    }

    /**
     * @return Game[]|int[]|null
     */
    public function getPublished()
    {
        return $this->published;
    }

    /**
     * @return int|null
     */
    public function getStartDate(): ?int
    {
        return $this->startDate;
    }

    /**
     * @return Website[]|int[]|null
     */
    public function getWebsites()
    {
        return $this->websites;
    }
}
