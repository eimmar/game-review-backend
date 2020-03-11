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


namespace App\Service\GameSpot\DTO\Review;

use App\Service\GameSpot\DTO\DTO;

class Game implements DTO
{
    /**
     * @var int
     */
    private $id;

    /**
     * @var string
     */
    private $name;

    /**
     * @var string
     */
    private $apiDetailUrl;

    /**
     * @var string
     */
    private $siteDetailUrl;

    /**
     * @param int $id
     * @param string $name
     * @param string $apiDetailUrl
     * @param string $siteDetailUrl
     */
    public function __construct(int $id, string $name, string $apiDetailUrl, string $siteDetailUrl)
    {
        $this->id = $id;
        $this->name = $name;
        $this->apiDetailUrl = $apiDetailUrl;
        $this->siteDetailUrl = $siteDetailUrl;
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
    public function getApiDetailUrl(): string
    {
        return $this->apiDetailUrl;
    }

    /**
     * @return string
     */
    public function getSiteDetailUrl(): string
    {
        return $this->siteDetailUrl;
    }
}
