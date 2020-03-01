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

use App\Service\IGDB\DTO\Company\CompanyLogo;
use App\Service\IGDB\DTO\Company\CompanyWebsite;
use App\Service\IGDB\Traits\TimestampableTrait;
use App\Service\IGDB\Traits\UrlIdentifiableTrait;

class Company
{
    use TimestampableTrait;
    use UrlIdentifiableTrait;

    /**
     * @var int|null
     */
    private $changeDate;

    /**
     * @var int|null
     */
    private $changeDateCategory;

    /**
     * @var Company|int|null
     */
    private $changedCompanyId;

    /**
     * @var int|null
     */
    private $country;

    /**
     * @var string|null
     */
    private $description;

    /**
     * @var CompanyLogo
     */
    private $logo;

    /**
     * @var Company|int|null
     */
    private $parent;

    /**
     * @var Game[]|int[]|null
     */
    private $published;

    /**
     * @var int|null
     */
    private $startDate;

    /**
     * @var CompanyWebsite[]|int[]|null
     */
    private $websites;

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
     * @return CompanyLogo
     */
    public function getLogo(): CompanyLogo
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
     * @return CompanyWebsite[]|int[]|null
     */
    public function getWebsites()
    {
        return $this->websites;
    }
}
