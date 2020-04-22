<?php

declare(strict_types=1);

namespace App\Eimmar\IGDBBundle\DTO;

use App\Eimmar\IGDBBundle\DTO\AgeRating\ContentDescription;
use App\Eimmar\IGDBBundle\Traits\IdentifiableTrait;

class AgeRating implements ResponseDTO
{
    use IdentifiableTrait;

    /**
     * @var int|null
     */
    private ?int $category;

    /**
     * @var int[]|null
     */
    private ?array $contentDescriptions;

    /**
     * @var int|null
     */
    private ?int $rating;

    /**
     * @var string|null
     */
    private ?string $ratingCoverUrl;

    /**
     * @var string|null
     */
    private ?string $synopsis;

    /**
     * @param int $id
     * @param int|null $category
     * @param ContentDescription[]|int[]|null $contentDescriptions
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
