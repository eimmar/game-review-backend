<?php

declare(strict_types=1);




namespace App\Entity\Game;

use App\Entity\Company\Website;
use App\Entity\ExternalEntityInterface;
use App\Entity\Game;
use App\Traits\ExternalEntityTrait;
use App\Traits\TimestampableTrait;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\HasLifecycleCallbacks
 */
class Company implements ExternalEntityInterface
{
    use TimestampableTrait;
    use ExternalEntityTrait;

    /**
     * @var string
     * @ORM\Id()
     * @ORM\Column(type="guid")
     * @ORM\GeneratedValue(strategy="UUID")
     */
    private string $id;

    /**
     * @var string
     * @ORM\Column(type="string", length=255, nullable=false)
     */
    private string $name;

    /**
     * @var string|null
     * @ORM\Column(type="string", length=10000, nullable=true)
     */
    private ?string $description;

    /**
     * @var string
     * @ORM\Column(type="string", length=255, nullable=false)
     */
    private string $url;

    /**
     * @var Website[]|ArrayCollection
     * @ORM\OneToMany(targetEntity="App\Entity\Company\Website", mappedBy="company", orphanRemoval=true, cascade={"persist"})
     */
    private $websites;

    /**
     * @var Game[]|ArrayCollection
     * @ORM\ManyToMany(targetEntity="App\Entity\Game", mappedBy="companies")
     */
    private $games;

    public function __construct()
    {
        $this->games = new ArrayCollection();
        $this->websites = new ArrayCollection();
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
    public function getDescription(): ?string
    {
        return $this->description;
    }

    /**
     * @param string|null $description
     */
    public function setDescription(?string $description): void
    {
        $this->description = $description;
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
     * @return Website[]|ArrayCollection
     */
    public function getWebsites(): ArrayCollection
    {
        return $this->websites;
    }

    /**
     * @param Website[]|ArrayCollection $websites
     */
    public function setWebsites(ArrayCollection $websites): void
    {
        $this->websites = $websites;
    }

    /**
     * @return Game[]|ArrayCollection
     */
    public function getGames(): ArrayCollection
    {
        return $this->games;
    }

    /**
     * @param Game[]|ArrayCollection $games
     */
    public function setGames(ArrayCollection $games): void
    {
        $this->games = $games;
    }
}
