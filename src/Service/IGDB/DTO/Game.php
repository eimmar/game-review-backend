<?php
declare(strict_types=1);

namespace App\Service\IGDB\DTO;

use App\Service\IGDB\Traits\TimestampableTrait;
use App\Service\IGDB\Traits\UrlIdentifiableTrait;

class Game
{
    use TimestampableTrait;
    use UrlIdentifiableTrait;

    /**
     * @var AgeRating[]|int[]|null
     */
    private $ageRatings;

    /**
     * @var double|null
     */
    private $aggregatedRating;

    /**
     * @var int|null
     */
    private $aggregatedRatingCount;

    /**
     * @var int[]|null
     */
    private $alternativeNames;

    /**
     * @var int[]|null
     */
    private $artworks;

    /**
     * @var Game[]|int[]|null
     */
    private $bundles;

    /**
     * @var int|null
     */
    private $category;

    /**
     * @var int|null
     */
    private $collection;

    /**
     * @var Cover|int|null
     */
    private $cover;

    /**
     * @var Game[]|int[]|null
     */
    private $dlcs;

    /**
     * @var Game[]|int[]|null
     */
    private $expansions;

    /**
     * @var Game[]|int[]|null
     */
    private $externalGames;

    /**
     * @var int|null
     */
    private $firstReleaseDate;

    /**
     * @var int|null
     */
    private $follows;

    /**
     * @var int|null
     */
    private $franchise;

    /**
     * @var int[]|null
     */
    private $franchises;

    /**
     * @var int[]|null
     */
    private $gameEngines;

    /**
     * @var GameMode[]|int[]|null
     */
    private $gameModes;

    /**
     * @var Genre[]|int[]|null
     */
    private $genres;

    /**
     * @var int|null
     */
    private $hypes;

    /**
     * @var InvolvedCompany[]|int[]|null
     */
    private $involvedCompanies;

    /**
     * @var int[]|null
     */
    private $keywords;

    /**
     * @var int[]|null
     */
    private $multiplayerModes;

    /**
     * @var Game|int|null
     */
    private $parentGame;

    /**
     * @var Platform[]|int[]|null
     */
    private $platforms;

    /**
     * @var PlayerPerspective[]|int[]|null
     */
    private $playerPerspectives;

    /**
     * @var float|null
     */
    private $popularity;

    /**
     * @var int|null
     */
    private $pulseCount;

    /**
     * @var float|null
     */
    private $rating;

    /**
     * @var int|null
     */
    private $ratingCount;

    /**
     * @var int[]|null
     */
    private $releaseDates;

    /**
     * @var Screenshot[]|int[]|null
     */
    private $screenshots;

    /**
     * @var Game[]|int[]|null
     */
    private $similarGames;

    /**
     * @var Game[]|int[]|null
     */
    private $standaloneExpansions;

    /**
     * @var int|null
     */
    private $status;

    /**
     * @var string|null
     */
    private $storyline;

    /**
     * @var string|null
     */
    private $summary;

    /**
     * @var int[]|null
     */
    private $tags;

    /**
     * @var Theme[]|null
     */
    private $themes;

    /**
     * @var TimeToBeat|int|null
     */
    private $timeToBeat;

    /**
     * @var float|null
     */
    private $totalRating;

    /**
     * @var int|null
     */
    private $totalRatingCount;

    /**
     * @var Game|int|null
     */
    private $versionParent;

    /**
     * @var string|null
     */
    private $versionTitle;

    /**
     * @var int[]|null
     */
    private $videos;

    /**
     * @var Website[]|int[]|null
     */
    private $websites;

    /**
     * @return AgeRating[]|int[]|null
     */
    public function getAgeRatings()
    {
        return $this->ageRatings;
    }

    /**
     * @return float|null
     */
    public function getAggregatedRating(): ?float
    {
        return $this->aggregatedRating;
    }

    /**
     * @return int|null
     */
    public function getAggregatedRatingCount(): ?int
    {
        return $this->aggregatedRatingCount;
    }

    /**
     * @return int[]|null
     */
    public function getAlternativeNames(): ?array
    {
        return $this->alternativeNames;
    }

    /**
     * @return int[]|null
     */
    public function getArtworks(): ?array
    {
        return $this->artworks;
    }

    /**
     * @return Game[]|int[]|null
     */
    public function getBundles()
    {
        return $this->bundles;
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
    public function getCollection(): ?int
    {
        return $this->collection;
    }

    /**
     * @return Cover|int|null
     */
    public function getCover()
    {
        return $this->cover;
    }

    /**
     * @return Game[]|int[]|null
     */
    public function getDlcs()
    {
        return $this->dlcs;
    }

    /**
     * @return Game[]|int[]|null
     */
    public function getExpansions()
    {
        return $this->expansions;
    }

    /**
     * @return Game[]|int[]|null
     */
    public function getExternalGames()
    {
        return $this->externalGames;
    }

    /**
     * @return int|null
     */
    public function getFirstReleaseDate(): ?int
    {
        return $this->firstReleaseDate;
    }

    /**
     * @return int|null
     */
    public function getFollows(): ?int
    {
        return $this->follows;
    }

    /**
     * @return int|null
     */
    public function getFranchise(): ?int
    {
        return $this->franchise;
    }

    /**
     * @return int[]|null
     */
    public function getFranchises(): ?array
    {
        return $this->franchises;
    }

    /**
     * @return int[]|null
     */
    public function getGameEngines(): ?array
    {
        return $this->gameEngines;
    }

    /**
     * @return GameMode[]|int[]|null
     */
    public function getGameModes()
    {
        return $this->gameModes;
    }

    /**
     * @return Genre[]|int[]|null
     */
    public function getGenres()
    {
        return $this->genres;
    }

    /**
     * @return int|null
     */
    public function getHypes(): ?int
    {
        return $this->hypes;
    }

    /**
     * @return InvolvedCompany[]|int[]|null
     */
    public function getInvolvedCompanies()
    {
        return $this->involvedCompanies;
    }

    /**
     * @return int[]|null
     */
    public function getKeywords(): ?array
    {
        return $this->keywords;
    }

    /**
     * @return int[]|null
     */
    public function getMultiplayerModes(): ?array
    {
        return $this->multiplayerModes;
    }

    /**
     * @return Game|int|null
     */
    public function getParentGame()
    {
        return $this->parentGame;
    }

    /**
     * @return Platform[]|int[]|null
     */
    public function getPlatforms()
    {
        return $this->platforms;
    }

    /**
     * @return PlayerPerspective[]|int[]|null
     */
    public function getPlayerPerspectives()
    {
        return $this->playerPerspectives;
    }

    /**
     * @return float|null
     */
    public function getPopularity(): ?float
    {
        return $this->popularity;
    }

    /**
     * @return int|null
     */
    public function getPulseCount(): ?int
    {
        return $this->pulseCount;
    }

    /**
     * @return float|null
     */
    public function getRating(): ?float
    {
        return $this->rating;
    }

    /**
     * @return int|null
     */
    public function getRatingCount(): ?int
    {
        return $this->ratingCount;
    }

    /**
     * @return int[]|null
     */
    public function getReleaseDates(): ?array
    {
        return $this->releaseDates;
    }

    /**
     * @return Screenshot[]|int[]|null
     */
    public function getScreenshots()
    {
        return $this->screenshots;
    }

    /**
     * @return Game[]|int[]|null
     */
    public function getSimilarGames()
    {
        return $this->similarGames;
    }

    /**
     * @return Game[]|int[]|null
     */
    public function getStandaloneExpansions()
    {
        return $this->standaloneExpansions;
    }

    /**
     * @return int|null
     */
    public function getStatus(): ?int
    {
        return $this->status;
    }

    /**
     * @return string|null
     */
    public function getStoryline(): ?string
    {
        return $this->storyline;
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
    public function getTags(): ?array
    {
        return $this->tags;
    }

    /**
     * @return Theme[]|null
     */
    public function getThemes(): ?array
    {
        return $this->themes;
    }

    /**
     * @return TimeToBeat|int|null
     */
    public function getTimeToBeat()
    {
        return $this->timeToBeat;
    }

    /**
     * @return float|null
     */
    public function getTotalRating(): ?float
    {
        return $this->totalRating;
    }

    /**
     * @return int|null
     */
    public function getTotalRatingCount(): ?int
    {
        return $this->totalRatingCount;
    }

    /**
     * @return Game|int|null
     */
    public function getVersionParent()
    {
        return $this->versionParent;
    }

    /**
     * @return string|null
     */
    public function getVersionTitle(): ?string
    {
        return $this->versionTitle;
    }

    /**
     * @return int[]|null
     */
    public function getVideos(): ?array
    {
        return $this->videos;
    }

    /**
     * @return Website[]|int[]|null
     */
    public function getWebsites()
    {
        return $this->websites;
    }
}
