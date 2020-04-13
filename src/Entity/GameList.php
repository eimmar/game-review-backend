<?php

namespace App\Entity;

use App\Enum\GameListPrivacyType;
use App\Traits\TimestampableTrait;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\PersistentCollection;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\HasLifecycleCallbacks
 * @ORM\Entity(repositoryClass="App\Repository\GameListRepository")
 */
class GameList
{
    use TimestampableTrait;

    /**
     * @Groups({"gameList"})
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
     * @Groups({"gameList"})
     * @var int
     * @Assert\NotBlank
     * @ORM\Column(type="integer", nullable=false)
     */
    private int $privacyType;

    /**
     * @Groups({"gameList"})
     * @var int
     * @Assert\NotBlank
     * @ORM\Column(type="integer", nullable=false)
     */
    private int $type;

    /**
     * @Groups({"gameList"})
     * @var string
     * @ORM\Column(type="string", length=255, nullable=false)
     */
    private string $name;

    /**
     * @var User
     * @ORM\ManyToOne(targetEntity="User", inversedBy="gameLists")
     *
     */
    private User $user;

    public function __construct(int $type, $user)
    {
        $this->games = new ArrayCollection();
        $this->privacyType = GameListPrivacyType::PRIVATE;
        $this->type = $type;
        $this->name = '';
        $this->user = $user;
    }

    /**
     * @param Game $game
     */
    public function addGame(Game $game)
    {
        if (!$this->games->contains($game)) {
            $this->games[] = $game;
            $game->addGameList($this);
        }
    }

    /**
     * @param Game $game
     */
    public function removeGame(Game $game)
    {
        if ($this->games->contains($game)) {
            $this->games->removeElement($game);
            $game->removeGameList($this);
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
    public function getGames()
    {
        return $this->games;
    }

    /**
     * @param Game[]|PersistentCollection $games
     */
    public function setGames(PersistentCollection $games): void
    {
        foreach ($games as $game) {
            $this->addGame($game);
        }
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
