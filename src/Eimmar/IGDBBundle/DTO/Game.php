<?php
declare(strict_types=1);

namespace App\Eimmar\IGDBBundle\DTO;

use App\Eimmar\IGDBBundle\DTO\Game\Cover;
use App\Eimmar\IGDBBundle\DTO\Game\GameMode;
use App\Eimmar\IGDBBundle\DTO\Game\Genre;
use App\Eimmar\IGDBBundle\DTO\Game\InvolvedCompany;
use App\Eimmar\IGDBBundle\DTO\Game\PlayerPerspective;
use App\Eimmar\IGDBBundle\DTO\Game\Screenshot;
use App\Eimmar\IGDBBundle\DTO\Game\Theme;
use App\Eimmar\IGDBBundle\DTO\Game\Website;
use App\Eimmar\IGDBBundle\Traits\TimestampableTrait;
use App\Eimmar\IGDBBundle\Traits\UrlIdentifiableTrait;
use App\Eimmar\IGDBBundle\Traits\IdentifiableTrait;

class Game implements ResponseDTO
{
    use TimestampableTrait;
    use UrlIdentifiableTrait;
    use IdentifiableTrait;

    /**
     * @var AgeRating[]|int[]|null
     */
    private ?array $ageRatings;

    /**
     * @var double|null
     */
    private ?float $aggregatedRating;

    /**
     * @var int|null
     */
    private ?int $aggregatedRatingCount;

    /**
     * @var int[]|null
     */
    private ?array $alternativeNames;

    /**
     * @var int[]|null
     */
    private ?array $artworks;

    /**
     * @var Game[]|int[]|null
     */
    private ?array $bundles;

    /**
     * @var int|null
     */
    private ?int $category;

    /**
     * @var int|null
     */
    private ?int $collection;

    /**
     * @var Cover|int|null
     */
    private $cover;

    /**
     * @var Game[]|int[]|null
     */
    private ?array $dlcs;

    /**
     * @var Game[]|int[]|null
     */
    private ?array $expansions;

    /**
     * @var Game[]|int[]|null
     */
    private ?array $externalGames;

    /**
     * @var int|null
     */
    private ?int $firstReleaseDate;

    /**
     * @var int|null
     */
    private ?int $follows;

    /**
     * @var int|null
     */
    private ?int $franchise;

    /**
     * @var int[]|null
     */
    private ?array $franchises;

    /**
     * @var int[]|null
     */
    private ?array $gameEngines;

    /**
     * @var GameMode[]|int[]|null
     */
    private ?array $gameModes;

    /**
     * @var Genre[]|int[]|null
     */
    private ?array $genres;

    /**
     * @var int|null
     */
    private ?int $hypes;

    /**
     * @var InvolvedCompany[]|int[]|null
     */
    private ?array $involvedCompanies;

    /**
     * @var int[]|null
     */
    private ?array $keywords;

    /**
     * @var int[]|null
     */
    private ?array $multiplayerModes;

    /**
     * @var Game|int|null
     */
    private $parentGame;

    /**
     * @var Platform[]|int[]|null
     */
    private ?array $platforms;

    /**
     * @var PlayerPerspective[]|int[]|null
     */
    private ?array $playerPerspectives;

    /**
     * @var float|null
     */
    private ?float $popularity;

    /**
     * @var int|null
     */
    private ?int $pulseCount;

    /**
     * @var float|null
     */
    private ?float $rating;

    /**
     * @var int|null
     */
    private ?int $ratingCount;

    /**
     * @var int[]|null
     */
    private ?array $releaseDates;

    /**
     * @var Screenshot[]|int[]|null
     */
    private ?array $screenshots;

    /**
     * @var Game[]|int[]|null
     */
    private ?array $similarGames;

    /**
     * @var Game[]|int[]|null
     */
    private ?array $standaloneExpansions;

    /**
     * @var int|null
     */
    private ?int $status;

    /**
     * @var string|null
     */
    private ?string $storyline;

    /**
     * @var string|null
     */
    private ?string $summary;

    /**
     * @var int[]|null
     */
    private ?array $tags;

    /**
     * @var Theme[]|null
     */
    private ?array $themes;

    /**
     * @var TimeToBeat|int|null
     */
    private $timeToBeat;

    /**
     * @var float|null
     */
    private ?float $totalRating;

    /**
     * @var int|null
     */
    private ?int $totalRatingCount;

    /**
     * @var Game|int|null
     */
    private $versionParent;

    /**
     * @var string|null
     */
    private ?string $versionTitle;

    /**
     * @var int[]|null
     */
    private ?array $videos;

    /**
     * @var Website[]|int[]|null
     */
    private ?array $websites;

    /**
     * @param int $id
     * @param AgeRating[]|int[]|null $ageRatings
     * @param float|null $aggregatedRating
     * @param int|null $aggregatedRatingCount
     * @param int[]|null $alternativeNames
     * @param int[]|null $artworks
     * @param Game[]|int[]|null $bundles
     * @param int|null $category
     * @param int|null $collection
     * @param Cover|int|null $cover
     * @param Game[]|int[]|null $dlcs
     * @param Game[]|int[]|null $expansions
     * @param Game[]|int[]|null $externalGames
     * @param int|null $firstReleaseDate
     * @param int|null $follows
     * @param int|null $franchise
     * @param int[]|null $franchises
     * @param int[]|null $gameEngines
     * @param GameMode[]|int[]|null $gameModes
     * @param Genre[]|int[]|null $genres
     * @param int|null $hypes
     * @param InvolvedCompany[]|int[]|null $involvedCompanies
     * @param int[]|null $keywords
     * @param int[]|null $multiplayerModes
     * @param Game|int|null $parentGame
     * @param Platform[]|int[]|null $platforms
     * @param PlayerPerspective[]|int[]|null $playerPerspectives
     * @param float|null $popularity
     * @param int|null $pulseCount
     * @param float|null $rating
     * @param int|null $ratingCount
     * @param int[]|null $releaseDates
     * @param Screenshot[]|int[]|null $screenshots
     * @param Game[]|int[]|null $similarGames
     * @param Game[]|int[]|null $standaloneExpansions
     * @param int|null $status
     * @param string|null $storyline
     * @param string|null $summary
     * @param int[]|null $tags
     * @param Theme[]|null $themes
     * @param TimeToBeat|int|null $timeToBeat
     * @param float|null $totalRating
     * @param int|null $totalRatingCount
     * @param Game|int|null $versionParent
     * @param string|null $versionTitle
     * @param int[]|null $videos
     * @param Website[]|int[]|null $websites
     * @param string|null $name
     * @param string|null $url
     * @param string|null $slug
     * @param int|null $updatedAt
     * @param int|null $createdAt
     */
    public function __construct(
        int $id,
        ?array $ageRatings = null,
        ?float $aggregatedRating = null,
        ?int $aggregatedRatingCount = null,
        ?array $alternativeNames = null,
        ?array $artworks = null,
        ?array $bundles = null,
        ?int $category = null,
        ?int $collection = null,
        ?array $dlcs = null,
        ?array $expansions = null,
        ?array $externalGames = null,
        ?int $firstReleaseDate = null,
        ?int $follows = null,
        ?int $franchise = null,
        ?array $franchises = null,
        ?array $gameEngines = null,
        ?array $gameModes = null,
        ?array $genres = null,
        ?int $hypes = null,
        ?array $involvedCompanies = null,
        ?array $keywords = null,
        ?array $multiplayerModes = null,
        ?array $platforms = null,
        ?array $playerPerspectives = null,
        ?float $popularity = null,
        ?int $pulseCount = null,
        ?float $rating = null,
        ?int $ratingCount = null,
        ?array $releaseDates = null,
        ?array $screenshots = null,
        ?array $similarGames = null,
        ?array $standaloneExpansions = null,
        ?int $status = null,
        ?string $storyline = null,
        ?string $summary = null,
        ?array $tags = null,
        ?array $themes = null,
        ?float $totalRating = null,
        ?int $totalRatingCount = null,
        ?string $versionTitle = null,
        ?array $videos = null,
        ?array $websites = null,
        ?string $name = null,
        ?string $url = null,
        ?string $slug = null,
        ?int $updatedAt = null,
        ?int $createdAt = null,
        $versionParent = null,
        $timeToBeat = null,
        $parentGame = null,
        $cover = null
    ) {
        $this->id = $id;
        $this->ageRatings = $ageRatings;
        $this->aggregatedRating = $aggregatedRating;
        $this->aggregatedRatingCount = $aggregatedRatingCount;
        $this->alternativeNames = $alternativeNames;
        $this->artworks = $artworks;
        $this->bundles = $bundles;
        $this->category = $category;
        $this->collection = $collection;
        $this->cover = $cover;
        $this->dlcs = $dlcs;
        $this->expansions = $expansions;
        $this->externalGames = $externalGames;
        $this->firstReleaseDate = $firstReleaseDate;
        $this->follows = $follows;
        $this->franchise = $franchise;
        $this->franchises = $franchises;
        $this->gameEngines = $gameEngines;
        $this->gameModes = $gameModes;
        $this->genres = $genres;
        $this->hypes = $hypes;
        $this->involvedCompanies = $involvedCompanies;
        $this->keywords = $keywords;
        $this->multiplayerModes = $multiplayerModes;
        $this->parentGame = $parentGame;
        $this->platforms = $platforms;
        $this->playerPerspectives = $playerPerspectives;
        $this->popularity = $popularity;
        $this->pulseCount = $pulseCount;
        $this->rating = $rating;
        $this->ratingCount = $ratingCount;
        $this->releaseDates = $releaseDates;
        $this->screenshots = $screenshots;
        $this->similarGames = $similarGames;
        $this->standaloneExpansions = $standaloneExpansions;
        $this->status = $status;
        $this->storyline = $storyline;
        $this->summary = $summary;
        $this->tags = $tags;
        $this->themes = $themes;
        $this->timeToBeat = $timeToBeat;
        $this->totalRating = $totalRating;
        $this->totalRatingCount = $totalRatingCount;
        $this->versionParent = $versionParent;
        $this->versionTitle = $versionTitle;
        $this->videos = $videos;
        $this->websites = $websites;
        $this->name = $name;
        $this->slug = $slug;
        $this->url = $url;
        $this->updatedAt = $updatedAt;
        $this->createdAt = $createdAt;
    }

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
