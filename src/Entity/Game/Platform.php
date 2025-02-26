<?php

declare(strict_types=1);




namespace App\Entity\Game;

use App\Entity\ExternalEntityInterface;
use App\Entity\Game;
use App\Traits\ExternalEntityTrait;
use App\Traits\TimestampableTrait;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\PersistentCollection;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * @ORM\Entity
 * @ORM\HasLifecycleCallbacks
 */
class Platform implements ExternalEntityInterface
{
    use TimestampableTrait;
    use ExternalEntityTrait;

    /**
     * @var string
     * @Groups({"gameLoaded"})
     * @ORM\Id()
     * @ORM\Column(type="guid")
     * @ORM\GeneratedValue(strategy="UUID")
     */
    private string $id;

    /**
     * @var string
     * @Groups({"gameLoaded"})
     * @ORM\Column(type="string", length=255)
     */
    private string $name;

    /**
     * @var string
     * @Groups({"gameLoaded"})
     * @ORM\Column(type="string", length=255)
     */
    private string $slug;

    /**
     * @var string|null
     * @Groups({"gameLoaded"})
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private ?string $abbreviation;

    /**
     * @var string|null
     * @Groups({"gameLoaded"})
     * @ORM\Column(type="string", length=10000, nullable=true)
     */
    private ?string $summary;

    /**
     * @var string
     * @Groups({"gameLoaded"})
     * @ORM\Column(type="string", length=255)
     */
    private string $url;

    /**
     * @var int
     * @Groups({"gameLoaded"})
     * @ORM\Column(type="integer")
     */
    private int $category;

    /**
     * @var Game[]|ArrayCollection
     * @ORM\ManyToMany(targetEntity="App\Entity\Game", mappedBy="platforms")
     */
    private $games;

    public function __construct()
    {
        $this->games = new ArrayCollection();
    }

    /**
     * @return string
     */
    public function getId(): string
    {
        return $this->id;
    }

    /**
     * @param string $id
     */
    public function setId(string $id): void
    {
        $this->id = $id;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @param string $name
     */
    public function setName(string $name): void
    {
        $this->name = $name;
    }

    /**
     * @return string|null
     */
    public function getAbbreviation(): ?string
    {
        return $this->abbreviation;
    }

    /**
     * @param string|null $abbreviation
     */
    public function setAbbreviation(?string $abbreviation): void
    {
        $this->abbreviation = $abbreviation;
    }

    /**
     * @return string|null
     */
    public function getSummary(): ?string
    {
        return $this->summary;
    }

    /**
     * @param string|null $summary
     */
    public function setSummary(?string $summary): void
    {
        $this->summary = $summary;
    }

    /**
     * @return string
     */
    public function getUrl(): string
    {
        return $this->url;
    }

    /**
     * @param string $url
     */
    public function setUrl(string $url): void
    {
        $this->url = $url;
    }

    /**
     * @return int
     */
    public function getCategory(): int
    {
        return $this->category;
    }

    /**
     * @param int $category
     */
    public function setCategory(int $category): void
    {
        $this->category = $category;
    }

    /**
     * @return Game[]|PersistentCollection
     */
    public function getGames(): PersistentCollection
    {
        return $this->games;
    }

    /**
     * @param Game[]|ArrayCollection $games
     */
    public function setGames(ArrayCollection $games): void
    {
        array_map([$this, 'addGame'], $games->toArray());
    }

    /**
     * @param Game $game
     */
    public function addGame(Game $game)
    {
        if (!$this->games->contains($game)) {
            $this->games[] = $game;
            $game->addPlatform($this);
        }
    }

    /**
     * @return string
     */
    public function getSlug(): string
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
