<?php

declare(strict_types=1);

namespace App\Eimmar\GameSpotBundle\DTO\Review;

use App\Eimmar\GameSpotBundle\DTO\DTO;

class GameReview implements DTO
{
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
    private string $apiDetailUrl;

    /**
     * @var string
     */
    private string $siteDetailUrl;

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
