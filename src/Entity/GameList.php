<?php

namespace App\Entity;

use App\Traits\TimestampableTrait;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\PersistentCollection;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\HasLifecycleCallbacks
 * @ORM\Entity
 */
class GameList
{
    use TimestampableTrait;

    /**
     * @var string
     * @ORM\Id()
     * @ORM\GeneratedValue(strategy="UUID")
     * @ORM\Column(type="guid")
     */
    private string $id;

    /**
     * @var Game[]|ArrayCollection
     * @ORM\ManyToMany(targetEntity="Game", mappedBy="gameLists")
     */
    private $games;

    /**
     * @var int
     * @Assert\NotBlank
     * @ORM\Column(type="integer", nullable=false)
     */
    private int $privacyType;

    /**
     * @var int
     * @Assert\NotBlank
     * @ORM\Column(type="integer", nullable=false)
     */
    private int $type;

    /**
     * @var string
     * @ORM\Column(type="string", length=255, nullable=false)
     */
    private string $name;

    /**
     * @var string|null
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private ?string $description;

    /**
     * @var User
     * @ORM\ManyToOne(targetEntity="User", inversedBy="gameLists")
     *
     */
    private User $user;

    public function __construct()
    {
        $this->games = new ArrayCollection();
    }

    /**
     * @param Game $game
     */
    public function addGame(Game $game)
    {
        if (!$this->games->contains($game)) {
            $this->games[] = $game;
        }
    }

    /**
     * @param Game $game
     */
    public function removeGame(Game $game)
    {
        if ($this->games->contains($game)) {
            $this->games->removeElement($game);
        }
    }

    /**
     * @return string
     */
    public function getId(): string
    {
        return $this->id;
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
        $this->games = $games;
    }

    /**
     * @return int
     */
    public function getPrivacyType(): int
    {
        return $this->privacyType;
    }

    /**
     * @param int $privacyType
     */
    public function setPrivacyType(int $privacyType): void
    {
        $this->privacyType = $privacyType;
    }

    /**
     * @return int
     */
    public function getType(): int
    {
        return $this->type;
    }

    /**
     * @param int $type
     */
    public function setType(int $type): void
    {
        $this->type = $type;
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
     * @return User
     */
    public function getUser(): User
    {
        return $this->user;
    }

    /**
     * @param User $user
     */
    public function setUser(User $user): void
    {
        $this->user = $user;
    }
}
