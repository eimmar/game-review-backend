<?php
declare(strict_types=1);

namespace App\Service\IGDB\DTO;

use App\Service\IGDB\DTO\Game\Cover;
use App\Service\IGDB\DTO\Game\GameMode;
use App\Service\IGDB\DTO\Game\Genre;
use App\Service\IGDB\DTO\Game\InvolvedCompany;
use App\Service\IGDB\DTO\Game\PlayerPerspective;
use App\Service\IGDB\DTO\Game\Screenshot;
use App\Service\IGDB\DTO\Game\Theme;
use App\Service\IGDB\DTO\Game\TimeToBeat;
use App\Service\IGDB\DTO\Game\Website;
use App\Service\IGDB\Traits\TimestampableTrait;
use App\Service\IGDB\Traits\UrlIdentifiableTrait;
use App\Traits\IdentifiableTrait;

class Game
{
    use TimestampableTrait;
    use UrlIdentifiableTrait;
    use IdentifiableTrait;

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
        ?array $ageRatings,
        ?float $aggregatedRating,
        ?int $aggregatedRatingCount,
        ?array $alternativeNames,
        ?array $artworks,
        ?array $bundles,
        ?int $category,
        ?int $collection,
        ?array $dlcs,
        ?array $expansions,
        ?array $externalGames,
        ?int $firstReleaseDate,
        ?int $follows,
        ?int $franchise,
        ?array $franchises,
        ?array $gameEngines,
        ?array $gameModes,
        ?array $genres,
        ?int $hypes,
        ?array $involvedCompanies,
        ?array $keywords,
        ?array $multiplayerModes,
        ?array $platforms,
        ?array $playerPerspectives,
        ?float $popularity,
        ?int $pulseCount,
        ?float $rating,
        ?int $ratingCount,
        ?array $releaseDates,
        ?array $screenshots,
        ?array $similarGames,
        ?array $standaloneExpansions,
        ?int $status,
        ?string $storyline,
        ?string $summary,
        ?array $tags,
        ?array $themes,
        ?float $totalRating,
        ?int $totalRatingCount,
        ?string $versionTitle,
        ?array $videos,
        ?array $websites,
        ?string $name,
        ?string $url,
        ?string $slug,
        ?int $updatedAt,
        ?int $createdAt,
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
