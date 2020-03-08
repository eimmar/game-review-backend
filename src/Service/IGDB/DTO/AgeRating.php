<?php

declare(strict_types=1);

namespace App\Service\IGDB\DTO;

use App\Traits\IdentifiableTrait;

class AgeRating
{
    use IdentifiableTrait;

    /**
     * @var int|null
     */
    private $category;

    /**
     * @var int[]|null
     */
    private $contentDescriptions;

    /**
     * @var int|null
     */
    private $rating;

    /**
     * @var string|null
     */
    private $ratingCoverUrl;

    /**
     * @var string|null
     */
    private $synopsis;

    /**
     * @param int $id
     * @param int|null $category
     * @param int[]|null $contentDescriptions
     * @param int|null $rating
     * @param string|null $ratingCoverUrl
     * @param string|null $synopsis
     */
    public function __construct(
        int $id,
        ?int $category,
        ?array $contentDescriptions,
        ?int $rating,
        ?string $ratingCoverUrl,
        ?string $synopsis
    ) {
        $this->id = $id;
        $this->category = $category;
        $this->contentDescriptions = $contentDescriptions;
        $this->rating = $rating;
        $this->ratingCoverUrl = $ratingCoverUrl;
        $this->synopsis = $synopsis;
    }

    /**
     * @return int|null
     */
    public function getCategory(): ?int
    {
        return $this->category;
    }

    /**
     * @return int[]|null
     */
    public function getContentDescriptions(): ?array
    {
        return $this->contentDescriptions;
    }

    /**
     * @return int|null
     */
    public function getRating(): ?int
    {
        return $this->rating;
    }

    /**
     * @return string|null
     */
    public function getRatingCoverUrl(): ?string
    {
        return $this->ratingCoverUrl;
    }

    /**
     * @return string|null
     */
    public function getSynopsis(): ?string
    {
        return $this->synopsis;
    }
}
