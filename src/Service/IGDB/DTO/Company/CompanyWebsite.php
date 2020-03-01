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


namespace App\Service\IGDB\DTO\Company;

class CompanyWebsite
{
    /**
     * @var int|null
     */
    private $category;

    /**
     * @var bool|null
     */
    private $trusted;

    /**
     * @var string|null
     */
    private $url;

    /**
     * @param int|null $category
     * @param bool|null $trusted
     * @param string|null $url
     */
    public function __construct(?int $category, ?bool $trusted, ?string $url)
    {
        $this->category = $category;
        $this->trusted = $trusted;
        $this->url = $url;
    }

    /**
     * @return int|null
     */
    public function getCategory(): ?int
    {
        return $this->category;
    }

    /**
     * @return bool|null
     */
    public function getTrusted(): ?bool
    {
        return $this->trusted;
    }

    /**
     * @return string|null
     */
    public function getUrl(): ?string
    {
        return $this->url;
    }
}
