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


namespace App\Eimmar\GameSpotBundle\DTO;

class Game implements DTO
{
    /**
     * @var string|null
     */
    private ?string $releaseDate;

    /**
     * @var string|null
     */
    private ?string $description;

    /**
     * @var int|null
     */
    private ?int $id;

    /**
     * @var string|null
     */
    private ?string $name;

    /**
     * @var string|null
     */
    private ?string $deck;

    /**
     * @var Image|null
     */
    private ?Image $image;

    /**
     * @var NameableEntity[]|null
     */
    private ?array $genres;

    /**
     * @var NameableEntity[]|null
     */
    private ?array $themes;

    /**
     * @var NameableEntity[]|null
     */
    private ?array $franchises;

    /**
     * @var string|null
     */
    private ?string $imagesApiUrl;

    /**
     * @var string|null
     */
    private ?string $reviewsApiUrl;

    /**
     * @var string|null
     */
    private ?string $articlesApiUrl;

    /**
     * @var string|null
     */
    private ?string $videosApiUrl;

    /**
     * @var string|null
     */
    private ?string $releasesApiUrl;

    /**
     * @var string|null
     */
    private ?string $siteDetailUrl;

    /**
     * @param string|null $releaseDate
     * @param string|null $description
     * @param int|null $id
     * @param string|null $name
     * @param string|null $deck
     * @param Image $image
     * @param NameableEntity[]|null $genres
     * @param NameableEntity[]|null $themes
     * @param NameableEntity[]|null $franchises
     * @param string|null $imagesApiUrl
     * @param string|null $reviewsApiUrl
     * @param string|null $articlesApiUrl
     * @param string|null $videosApiUrl
     * @param string|null $releasesApiUrl
     * @param string|null $siteDetailUrl
     */
    public function __construct(
        ?string $releaseDate = null,
        ?string $description = null,
        ?int $id = null,
        ?string $name = null,
        ?string $deck = null,
        ?Image $image = null,
        ?array $genres = null,
        ?array $themes = null,
        ?array $franchises = null,
        ?string $imagesApiUrl = null,
        ?string $reviewsApiUrl = null,
        ?string $articlesApiUrl = null,
        ?string $videosApiUrl = null,
        ?string $releasesApiUrl = null,
        ?string $siteDetailUrl = null
    ) {
        $this->releaseDate = $releaseDate;
        $this->description = $description;
        $this->id = $id;
        $this->name = $name;
        $this->deck = $deck;
        $this->image = $image;
        $this->genres = $genres;
        $this->themes = $themes;
        $this->franchises = $franchises;
        $this->imagesApiUrl = $imagesApiUrl;
        $this->reviewsApiUrl = $reviewsApiUrl;
        $this->articlesApiUrl = $articlesApiUrl;
        $this->videosApiUrl = $videosApiUrl;
        $this->releasesApiUrl = $releasesApiUrl;
        $this->siteDetailUrl = $siteDetailUrl;
    }

    /**
     * @return string|null
     */
    public function getReleaseDate(): ?string
    {
        return $this->releaseDate;
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
    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @return string|null
     */
    public function getName(): ?string
    {
        return $this->name;
    }

    /**
     * @return string|null
     */
    public function getDeck(): ?string
    {
        return $this->deck;
    }

    /**
     * @return Image|null
     */
    public function getImage(): ?Image
    {
        return $this->image;
    }

    /**
     * @return NameableEntity[]|null
     */
    public function getGenres(): ?array
    {
        return $this->genres;
    }

    /**
     * @return NameableEntity[]|null
     */
    public function getThemes(): ?array
    {
        return $this->themes;
    }

    /**
     * @return NameableEntity[]|null
     */
    public function getFranchises(): ?array
    {
        return $this->franchises;
    }

    /**
     * @return string|null
     */
    public function getImagesApiUrl(): ?string
    {
        return $this->imagesApiUrl;
    }

    /**
     * @return string|null
     */
    public function getReviewsApiUrl(): ?string
    {
        return $this->reviewsApiUrl;
    }

    /**
     * @return string|null
     */
    public function getArticlesApiUrl(): ?string
    {
        return $this->articlesApiUrl;
    }

    /**
     * @return string|null
     */
    public function getVideosApiUrl(): ?string
    {
        return $this->videosApiUrl;
    }

    /**
     * @return string|null
     */
    public function getReleasesApiUrl(): ?string
    {
        return $this->releasesApiUrl;
    }

    /**
     * @return string|null
     */
    public function getSiteDetailUrl(): ?string
    {
        return $this->siteDetailUrl;
    }
}
