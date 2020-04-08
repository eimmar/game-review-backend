<?php

namespace App\Entity;

use App\Entity\Game\AgeRating;
use App\Entity\Game\Company;
use App\Entity\Game\GameMode;
use App\Entity\Game\Genre;
use App\Entity\Game\Platform;
use App\Entity\Game\Screenshot;
use App\Entity\Game\Theme;
use App\Entity\Game\Website;
use App\Traits\ExternalEntityTrait;
use App\Traits\TimestampableTrait;
use DateTime;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\PersistentCollection;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * @ORM\Entity(repositoryClass="App\Repository\GameRepository")
 * @ORM\HasLifecycleCallbacks
 */
class Game implements ExternalEntityInterface
{
    use TimestampableTrait;
    use ExternalEntityTrait;

    /**
     * @var string
     * @Groups({"gameLoaded", "game"})
     * @ORM\Id()
     * @ORM\Column(type="guid")
     * @ORM\GeneratedValue(strategy="UUID")
     */
    private string $id;

    /**
     * @var string
     * @Groups({"gameLoaded", "game"})
     * @ORM\Column(type="string", length=255)
     */
    private string $name;

    /**
     * @var string|null
     * @Groups({"gameLoaded", "game"})
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private ?string $coverImage;

    /**
     * @var string|null
     * @Groups({"gameLoaded", "game"})
     * @ORM\Column(type="string", length=10000, nullable=true)
     */
    private ?string $summary;

    /**
     * @var string|null
     * @Groups({"gameLoaded", "game"})
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private ?string $storyline;

    /**
     * @var DateTime|null
     * @Groups({"gameLoaded", "game"})
     * @ORM\Column(type="datetime", length=255, nullable=true)
     */
    private ?DateTime $releaseDate;

    /**
     * @var int|null
     * @Groups({"gameLoaded", "game"})
     * @ORM\Column(type="integer", length=255, nullable=true)
     */
    private ?int $category;

    /**
     * @var float|null
     * @Groups({"gameLoaded", "game"})
     * @ORM\Column(type="float", nullable=true)
     */
    private ?float $rating;

    /**
     * @var int|null
     * @Groups({"gameLoaded", "game"})
     * @ORM\Column(type="integer", nullable=true)
     */
    private ?int $ratingCount;

    /**
     * @var AgeRating[]|ArrayCollection
     * @Groups({"gameLoaded"})
     * @ORM\OneToMany(targetEntity="App\Entity\Game\AgeRating", mappedBy="game", cascade={"persist"})
     */
    private $ageRatings;

    /**
     * @var Genre[]|ArrayCollection
     * @Groups({"gameLoaded"})
     * @ORM\ManyToMany(targetEntity="App\Entity\Game\Genre", inversedBy="games", cascade={"persist"})
     */
    private $genres;

    /**
     * @var Screenshot[]|ArrayCollection
     * @Groups({"gameLoaded"})
     * @ORM\OneToMany(targetEntity="App\Entity\Game\Screenshot", mappedBy="game", orphanRemoval=true, cascade={"persist"})
     */
    private $screenshots;

    /**
     * @var Theme[]|ArrayCollection
     * @Groups({"gameLoaded"})
     * @ORM\ManyToMany(targetEntity="App\Entity\Game\Theme", inversedBy="games", cascade={"persist"})
     */
    private $themes;

    /**
     * @var Platform[]|ArrayCollection
     * @Groups({"gameLoaded"})
     * @ORM\ManyToMany(targetEntity="App\Entity\Game\Platform", inversedBy="games", cascade={"persist"})
     */
    private $platforms;

    /**
     * @var GameMode[]|ArrayCollection
     * @Groups({"gameLoaded"})
     * @ORM\ManyToMany(targetEntity="App\Entity\Game\GameMode", inversedBy="games", cascade={"persist"})
     */
    private $gameModes;

    /**
     * @var string|null
     * @Groups({"gameLoaded", "game"})
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private ?string $gameSpotAssociation;

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

//    /**
//     * @var int|null
//     * @ORM\Column(type="integer", nullable=true)
//     */
//    private ?int $timeToBeatCompletely;
//
//    /**
//     * @var int|null
//     * @ORM\Column(type="integer", nullable=false)
//     */
//    private ?int $timeToBeatHastly;
//
//    /**
//     * @var int|null
//     * @ORM\Column(type="integer", nullable=false)
//     */
//    private ?int $timeToBeatNormally;

    /**
     * @var Website[]|ArrayCollection
     * @Groups({"gameLoaded"})
     * @ORM\OneToMany(targetEntity="App\Entity\Game\Website", mappedBy="game", orphanRemoval=true, cascade={"persist"})
     */
    private $websites;

    /**
     * @var Company[]|ArrayCollection
     * @Groups({"gameLoaded"})
     * @ORM\ManyToMany(targetEntity="App\Entity\Game\Company", inversedBy="games", cascade={"persist"})
     */
    private $companies;

    /**
     * @var Review[]|ArrayCollection
     * @ORM\OneToMany(targetEntity="App\Entity\Review", mappedBy="game", orphanRemoval=true, cascade={"persist"})
     */
    private $reviews;

    /**
     * @var GameList[]|ArrayCollection
     * @ORM\ManyToMany(targetEntity="App\Entity\GameList", inversedBy="games", cascade={"persist"})
     */
    private $gameLists;

    public function __construct()
    {
        $this->ageRatings = new ArrayCollection();
        $this->genres = new ArrayCollection();
        $this->screenshots = new ArrayCollection();
        $this->themes = new ArrayCollection();
        $this->platforms = new ArrayCollection();
        $this->gameModes = new ArrayCollection();
        $this->websites = new ArrayCollection();
        $this->companies = new ArrayCollection();
        $this->reviews = new ArrayCollection();
        $this->gameLists = new ArrayCollection();
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
     * @return DateTime|null
     */
    public function getReleaseDate(): ?DateTime
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
     * @return AgeRating[]|PersistentCollection
     */
    public function getAgeRatings(): PersistentCollection
    {
        return $this->ageRatings;
    }

    /**
     * @return Genre[]|PersistentCollection
     */
    public function getGenres(): PersistentCollection
    {
        return $this->genres;
    }

    /**
     * @return Screenshot[]|PersistentCollection
     */
    public function getScreenshots(): PersistentCollection
    {
        return $this->screenshots;
    }

    /**
     * @return Theme[]|PersistentCollection
     */
    public function getThemes(): PersistentCollection
    {
        return $this->themes;
    }

    /**
     * @return Platform[]|PersistentCollection
     */
    public function getPlatforms(): PersistentCollection
    {
        return $this->platforms;
    }

    /**
     * @return GameMode[]|PersistentCollection
     */
    public function getGameModes(): PersistentCollection
    {
        return $this->gameModes;
    }

//    /**
//     * @return int|null
//     */
//    public function getTimeToBeatCompletely(): ?int
//    {
//        return $this->timeToBeatCompletely;
//    }
//
//    /**
//     * @return int|null
//     */
//    public function getTimeToBeatHastly(): ?int
//    {
//        return $this->timeToBeatHastly;
//    }
//
//    /**
//     * @return int|null
//     */
//    public function getTimeToBeatNormally(): ?int
//    {
//        return $this->timeToBeatNormally;
//    }

    /**
     * @return Website[]|PersistentCollection
     */
    public function getWebsites(): PersistentCollection
    {
        return $this->websites;
    }

    /**
     * @return Company[]|PersistentCollection
     */
    public function getCompanies(): PersistentCollection
    {
        return $this->companies;
    }

    /**
     * @return Review[]|PersistentCollection
     */
    public function getReviews(): PersistentCollection
    {
        return $this->reviews;
    }

    /**
     * @return GameList[]|PersistentCollection
     */
    public function getGameLists(): PersistentCollection
    {
        return $this->gameLists;
    }

    /**
     * @param string $name
     */
    public function setName(string $name): void
    {
        $this->name = $name;
    }

    /**
     * @param string|null $coverImage
     */
    public function setCoverImage(?string $coverImage): void
    {
        $this->coverImage = $coverImage;
    }

    /**
     * @param string|null $summary
     */
    public function setSummary(?string $summary): void
    {
        $this->summary = $summary;
    }

    /**
     * @param string|null $storyline
     */
    public function setStoryline(?string $storyline): void
    {
        $this->storyline = $storyline;
    }

    /**
     * @param DateTime|null $releaseDate
     */
    public function setReleaseDate(?DateTime $releaseDate): void
    {
        $this->releaseDate = $releaseDate;
    }

    /**
     * @param int|null $category
     */
    public function setCategory(?int $category): void
    {
        $this->category = $category;
    }

    /**
     * @param AgeRating[]|ArrayCollection $ageRatings
     */
    public function setAgeRatings(ArrayCollection $ageRatings): void
    {
        $this->ageRatings = $ageRatings->map(function (AgeRating $it) {
            $it->setGame($this);

            return $it;
        });
    }

    /**
     * @param Genre[]|ArrayCollection $genres
     */
    public function setGenres(ArrayCollection $genres): void
    {
        $this->genres = $genres;
    }

    /**
     * @param Screenshot[]|ArrayCollection $screenshots
     */
    public function setScreenshots(ArrayCollection $screenshots): void
    {
        $this->screenshots = $screenshots->map(function (Screenshot $it) {
            $it->setGame($this);

            return $it;
        });
    }

    /**
     * @param Theme[]|ArrayCollection $themes
     */
    public function setThemes(ArrayCollection $themes): void
    {
        $this->themes = $themes;
    }

    /**
     * @param Platform[]|ArrayCollection $platforms
     */
    public function setPlatforms(ArrayCollection $platforms): void
    {
        $this->platforms = $platforms;
    }

    /**
     * @param GameMode[]|ArrayCollection $gameModes
     */
    public function setGameModes(ArrayCollection $gameModes): void
    {
        $this->gameModes = $gameModes;
    }

//    /**
//     * @param int|null $timeToBeatCompletely
//     */
//    public function setTimeToBeatCompletely(?int $timeToBeatCompletely): void
//    {
//        $this->timeToBeatCompletely = $timeToBeatCompletely;
//    }
//
//    /**
//     * @param int|null $timeToBeatHastly
//     */
//    public function setTimeToBeatHastly(?int $timeToBeatHastly): void
//    {
//        $this->timeToBeatHastly = $timeToBeatHastly;
//    }
//
//    /**
//     * @param int|null $timeToBeatNormally
//     */
//    public function setTimeToBeatNormally(?int $timeToBeatNormally): void
//    {
//        $this->timeToBeatNormally = $timeToBeatNormally;
//    }

    /**
     * @param Website[]|ArrayCollection $websites
     */
    public function setWebsites(ArrayCollection $websites): void
    {
        $this->websites = $websites->map(function (Website $it) {
            $it->setGame($this);

            return $it;
        });
    }

    /**
     * @param Company[]|ArrayCollection $companies
     */
    public function setCompanies(ArrayCollection $companies): void
    {
        $this->companies = $companies;
    }

    /**
     * @param Review[]|ArrayCollection $reviews
     */
    public function setReviews(ArrayCollection $reviews): void
    {
        $this->reviews = $reviews;
    }

    /**
     * @param GameList[]|ArrayCollection $gameLists
     */
    public function setGameLists(ArrayCollection $gameLists): void
    {
        $this->gameLists = $gameLists;
    }

    /**
     * @return float|null
     */
    public function getRating(): ?float
    {
        return $this->rating;
    }

    /**
     * @param float|null $rating
     */
    public function setRating(?float $rating): void
    {
        $this->rating = $rating;
    }

    /**
     * @return int|null
     */
    public function getRatingCount(): ?int
    {
        return $this->ratingCount;
    }

    /**
     * @param int|null $ratingCount
     */
    public function setRatingCount(?int $ratingCount): void
    {
        $this->ratingCount = $ratingCount;
    }

    /**
     * @return string|null
     */
    public function getGameSpotAssociation(): ?string
    {
        return $this->gameSpotAssociation;
    }

    /**
     * @param string|null $gameSpotAssociation
     */
    public function setGameSpotAssociation(?string $gameSpotAssociation): void
    {
        $this->gameSpotAssociation = $gameSpotAssociation;
    }
}
