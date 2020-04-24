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
 * @ORM\Table(
 *     name="game",
 *     indexes={@ORM\Index(columns={"name"}, flags={"fulltext"})}
 *     )
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
    private $id;

    /**
     * @var string
     * @Groups({"gameLoaded", "game"})
     * @ORM\Column(type="string", length=255)
     */
    private string $name;

    /**
     * @var string
     * @Groups({"gameLoaded", "game"})
     * @ORM\Column(type="string", length=255)
     */
    private string $slug;

    /**
     * @var string|null
     * @Groups({"gameLoaded", "game"})
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $coverImage;

    /**
     * @var string|null
     * @Groups({"gameLoaded", "game"})
     * @ORM\Column(type="text", length=20000, nullable=true)
     */
    private $summary;

    /**
     * @var string|null
     * @Groups({"gameLoaded"})
     * @ORM\Column(type="text", length=20000, nullable=true)
     */
    private $storyline;

    /**
     * @var DateTime|null
     * @Groups({"gameLoaded", "game"})
     * @ORM\Column(type="datetime", length=255, nullable=true)
     */
    private $releaseDate;

    /**
     * @var int|null
     * @Groups({"gameLoaded", "game"})
     * @ORM\Column(type="integer", length=255, nullable=true)
     */
    private $category;

    /**
     * @var float|null
     * @Groups({"gameLoaded", "game"})
     * @ORM\Column(type="float", nullable=true)
     */
    private $rating;

    /**
     * @var int|null
     * @Groups({"gameLoaded", "game"})
     * @ORM\Column(type="integer", nullable=true)
     */
    private $ratingCount;

    /**
     * @var AgeRating[]|ArrayCollection
     * @Groups({"gameLoaded"})
     * @ORM\OneToMany(targetEntity="App\Entity\Game\AgeRating", mappedBy="game", cascade={"persist", "remove"})
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
     * @ORM\OneToMany(targetEntity="App\Entity\Game\Screenshot", mappedBy="game", orphanRemoval=true, cascade={"persist", "remove"})
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
    private $gameSpotAssociation;

    /**
     * @var Website[]|ArrayCollection
     * @Groups({"gameLoaded"})
     * @ORM\OneToMany(targetEntity="App\Entity\Game\Website", mappedBy="game", orphanRemoval=true, cascade={"persist", "remove"})
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
     * @ORM\OneToMany(targetEntity="App\Entity\GameListGame", mappedBy="game", cascade={"persist"})
     */
    private $gameListGames;

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
        $this->gameListGames = new ArrayCollection();
    }

    /**
     * @return string
     */
    public function __toString()
    {
        return $this->getName();
    }

    /**
     * @return string|null
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @return string|null
     */
    public function getCoverImage()
    {
        return $this->coverImage;
    }

    /**
     * @return string|null
     */
    public function getSummary()
    {
        return $this->summary;
    }

    /**
     * @return string|null
     */
    public function getStoryline()
    {
        return $this->storyline;
    }

    /**
     * @return DateTime|null
     */
    public function getReleaseDate()
    {
        return $this->releaseDate;
    }

    /**
     * @return int|null
     */
    public function getCategory()
    {
        return $this->category;
    }

    /**
     * @return AgeRating[]|PersistentCollection
     */
    public function getAgeRatings()
    {
        return $this->ageRatings;
    }

    /**
     * @return Genre[]|PersistentCollection
     */
    public function getGenres()
    {
        return $this->genres;
    }

    /**
     * @return Screenshot[]|PersistentCollection
     */
    public function getScreenshots()
    {
        return $this->screenshots;
    }

    /**
     * @return Theme[]|PersistentCollection
     */
    public function getThemes()
    {
        return $this->themes;
    }

    /**
     * @return Platform[]|PersistentCollection
     */
    public function getPlatforms()
    {
        return $this->platforms;
    }

    /**
     * @return GameMode[]|PersistentCollection
     */
    public function getGameModes()
    {
        return $this->gameModes;
    }

    /**
     * @return Website[]|PersistentCollection
     */
    public function getWebsites()
    {
        return $this->websites;
    }

    /**
     * @return Company[]|PersistentCollection
     */
    public function getCompanies()
    {
        return $this->companies;
    }

    /**
     * @return Review[]|PersistentCollection
     */
    public function getReviews()
    {
        return $this->reviews;
    }

    /**
     * @return GameList[]|PersistentCollection
     */
    public function getGameListGames()
    {
        return $this->gameListGames;
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
        array_map([$this, 'addGenre'], $genres->toArray());
    }

    /**
     * @param Genre $genre
     */
    public function addGenre(Genre $genre)
    {
        if (!$this->genres->contains($genre)) {
            $this->genres[] = $genre;
            $genre->addGame($this);
        }
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
        array_map([$this, 'addTheme'], $themes->toArray());
    }

    /**
     * @param Theme $theme
     */
    public function addTheme(Theme $theme)
    {
        if (!$this->themes->contains($theme)) {
            $this->themes[] = $theme;
            $theme->addGame($this);
        }
    }

    /**
     * @param Platform[]|ArrayCollection $platforms
     */
    public function setPlatforms(ArrayCollection $platforms): void
    {
        array_map([$this, 'addPlatform'], $platforms->toArray());
    }

    /**
     * @param Platform $platform
     */
    public function addPlatform(Platform $platform)
    {
        if (!$this->platforms->contains($platform)) {
            $this->platforms[] = $platform;
            $platform->addGame($this);
        }
    }

    /**
     * @param GameMode[]|ArrayCollection $gameModes
     */
    public function setGameModes(ArrayCollection $gameModes): void
    {
        array_map([$this, 'addGameMode'], $gameModes->toArray());
    }

    /**
     * @param GameMode $gameMode
     */
    public function addGameMode(GameMode $gameMode)
    {
        if (!$this->gameModes->contains($gameMode)) {
            $this->gameModes[] = $gameMode;
            $gameMode->addGame($this);
        }
    }

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
        array_map([$this, 'addCompany'], $companies->toArray());
    }

    /**
     * @param Company $company
     */
    public function addCompany(Company $company)
    {
        if (!$this->companies->contains($company)) {
            $this->companies[] = $company;
            $company->addGame($this);
        }
    }

    /**
     * @param Review[]|ArrayCollection $reviews
     */
    public function setReviews(ArrayCollection $reviews): void
    {
        $this->reviews = $reviews;
    }

    /**
     * @param ArrayCollection $gameListGames
     */
    public function setGameListGames(ArrayCollection $gameListGames)
    {
        $this->gameListGames = $gameListGames;
//        array_map([$this, 'addGameList'], $gameLists->toArray());
    }

//    /**
//     * @param GameList $gameList
//     */
//    public function addGameList(GameList $gameList)
//    {
//        if (!$this->gameLists->contains($gameList)) {
//            $this->gameLists[] = $gameList;
//            $gameList->addGame($this);
//        }
//    }
//
//    /**
//     * @param GameList $gameList
//     */
//    public function removeGameList(GameList $gameList)
//    {
//        if ($this->gameLists->contains($gameList)) {
//            $this->gameLists->removeElement($gameList);
//            $gameList->removeGame($this);
//        }
//    }

    /**
     * @return float|null
     */
    public function getRating()
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
    public function getRatingCount()
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
    public function getGameSpotAssociation()
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

    /**
     * @return string
     */
    public function getSlug()
    {
        return $this->slug;
    }

    /**
     * @param string $slug
     */
    public function setSlug(string $slug): void
    {
        $this->slug = $slug;
    }
}
