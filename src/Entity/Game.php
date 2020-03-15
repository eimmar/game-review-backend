<?php

namespace App\Entity;

use App\Entity\Game\AgeRating;
use App\Entity\Game\AggregatedRating;
use App\Entity\Game\Company;
use App\Entity\Game\GameMode;
use App\Entity\Game\Genre;
use App\Entity\Game\Platform;
use App\Entity\Game\Screenshot;
use App\Entity\Game\Theme;
use App\Entity\Game\Website;
use App\Traits\TimestampableTrait;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\GameRepository")
 */
class Game
{
    use TimestampableTrait;

    /**
     * @var string
     * @ORM\Id()
     * @ORM\Column(type="guid")
     * @ORM\GeneratedValue(strategy="UUID")
     */
    private $id;

    /**
     * @var string
     * @ORM\Column(type="string", length=255, unique=true)
     */
    private $externalId;

    /**
     * @var string
     * @ORM\Column(type="string", length=255)
     */
    private $name;

    /**
     * @var string|null
     * @ORM\Column(type="string", length=255)
     */
    private $coverImage;

    /**
     * @var string|null
     * @ORM\Column(type="string", length=255)
     */
    private $summary;

    /**
     * @var string|null
     * @ORM\Column(type="string", length=255)
     */
    private $storyline;

    /**
     * @var string|null
     * @ORM\Column(type="datetime", length=255, nullable=true)
     */
    private $releaseDate;

    /**
     * @var int|null
     * @ORM\Column(type="integer", length=255, nullable=true)
     */
    private $category;

    /**
     * @var AgeRating[]|ArrayCollection
     * @ORM\ManyToMany(targetEntity="App\Entity\Game\AgeRating", inversedBy="games")
     */
    private $ageRatings;

    /**
     * @var Genre[]|ArrayCollection
     * @ORM\ManyToMany(targetEntity="App\Entity\Game\Genre", inversedBy="games")
     */
    private $genres;

    /**
     * @var Screenshot[]|ArrayCollection
     * @ORM\OneToMany(targetEntity="App\Entity\Game\Screenshot", mappedBy="game", orphanRemoval=true)
     */
    private $screenshots;

    /**
     * @var Theme[]|ArrayCollection
     * @ORM\ManyToMany(targetEntity="App\Entity\Game\Theme", inversedBy="games")
     */
    private $themes;

    /**
     * @var Platform[]|ArrayCollection
     * @ORM\ManyToMany(targetEntity="App\Entity\Game\Platform", inversedBy="games")
     */
    private $platforms;

    /**
     * @var AggregatedRating[]|ArrayCollection
     * @ORM\OneToMany(targetEntity="App\Entity\Game\AggregatedRating", mappedBy="game", orphanRemoval=true)
     */
    private $aggregatedRatings;

    /**
     * @var GameMode[]|ArrayCollection
     * @ORM\ManyToMany(targetEntity="App\Entity\Game\GameMode", inversedBy="games")
     */
    private $gameModes;

    //TODO: Implement similar games relations
//    /**
//     * @var GameReview[]|ArrayCollection
//     * @ORM\ManyToMany(targetEntity="App\Entity\GameReview", inversedBy="similarGamesSource")
//     * @ORM\JoinTable(name="similar_games_relations",
//     *      joinColumns={@ORM\JoinColumn(name="game_id", referencedColumnName="external_id")},
//     *      inverseJoinColumns={@ORM\JoinColumn(name="similar_game_id", referencedColumnName="external_id")}
//     *      )
//     */
//    private $similarGames;
//
//    /**
//     * @var GameReview[]|ArrayCollection
//     * @ORM\ManyToMany(targetEntity="App\Entity\GameReview", mappedBy="similarGames")
//     */
//    protected $similarGamesSource;

    /**
     * @var int|null
     * @ORM\Column(type="integer", nullable=true)
     */
    private $timeToBeatCompletely;

    /**
     * @var int|null
     * @ORM\Column(type="integer", nullable=false)
     */
    private $timeToBeatHastly;

    /**
     * @var int|null
     * @ORM\Column(type="integer", nullable=false)
     */
    private $timeToBeatNormally;

    /**
     * @var Website[]|ArrayCollection
     * @ORM\OneToMany(targetEntity="App\Entity\Game\Website", mappedBy="game", orphanRemoval=true)
     */
    private $websites;

    /**
     * @var Company[]|ArrayCollection
     * @ORM\ManyToMany(targetEntity="App\Entity\Game\Company", inversedBy="games")
     */
    private $companies;

    /**
     * @var Review[]|ArrayCollection
     * @ORM\OneToMany(targetEntity="App\Entity\Review", mappedBy="game", orphanRemoval=true)
     */
    private $reviews;

    /**
     * @var GameList[]|ArrayCollection
     * @ORM\ManyToMany(targetEntity="App\Entity\GameList", inversedBy="games")
     */
    private $gameLists;

    public function __construct()
    {
        $this->reviews = new ArrayCollection();
    }

    /**
     * @return string
     */
    public function getId(): string
    {
        return $this->id;
    }

    /**
     * @return string
     */
    public function getExternalId(): string
    {
        return $this->externalId;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @return string|null
     */
    public function getCoverImage(): ?string
    {
        return $this->coverImage;
    }

    /**
     * @return string|null
     */
    public function getSummary(): ?string
    {
        return $this->summary;
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
    public function getReleaseDate(): ?string
    {
        return $this->releaseDate;
    }

    /**
     * @return int|null
     */
    public function getCategory(): ?int
    {
        return $this->category;
    }

    /**
     * @return AgeRating[]|ArrayCollection
     */
    public function getAgeRatings()
    {
        return $this->ageRatings;
    }

    /**
     * @return Genre[]|ArrayCollection
     */
    public function getGenres()
    {
        return $this->genres;
    }

    /**
     * @return Screenshot[]|ArrayCollection
     */
    public function getScreenshots()
    {
        return $this->screenshots;
    }

    /**
     * @return Theme[]|ArrayCollection
     */
    public function getThemes()
    {
        return $this->themes;
    }

    /**
     * @return Platform[]|ArrayCollection
     */
    public function getPlatforms()
    {
        return $this->platforms;
    }

    /**
     * @return AggregatedRating[]|ArrayCollection
     */
    public function getAggregatedRatings()
    {
        return $this->aggregatedRatings;
    }

    /**
     * @return GameMode[]|ArrayCollection
     */
    public function getGameModes()
    {
        return $this->gameModes;
    }

    /**
     * @return int|null
     */
    public function getTimeToBeatCompletely(): ?int
    {
        return $this->timeToBeatCompletely;
    }

    /**
     * @return int|null
     */
    public function getTimeToBeatHastly(): ?int
    {
        return $this->timeToBeatHastly;
    }

    /**
     * @return int|null
     */
    public function getTimeToBeatNormally(): ?int
    {
        return $this->timeToBeatNormally;
    }

    /**
     * @return Website[]|ArrayCollection
     */
    public function getWebsites()
    {
        return $this->websites;
    }

    /**
     * @return Company[]|ArrayCollection
     */
    public function getCompanies()
    {
        return $this->companies;
    }

    /**
     * @return Review[]|ArrayCollection
     */
    public function getReviews()
    {
        return $this->reviews;
    }

    /**
     * @return GameList[]|ArrayCollection
     */
    public function getGameLists()
    {
        return $this->gameLists;
    }
}
