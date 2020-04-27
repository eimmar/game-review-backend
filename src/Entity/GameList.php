<?php

namespace App\Entity;

use App\Enum\GameListPrivacyType;
use App\Traits\TimestampableTrait;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\Mapping\UniqueConstraint;
use Doctrine\ORM\PersistentCollection;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\HasLifecycleCallbacks
 * @ORM\Entity(repositoryClass="App\Repository\GameListRepository")
 * @ORM\Table(name="game_list",
 *    uniqueConstraints={
 *       @UniqueConstraint(name="unique_user_list_name", columns={"user_id", "name", "type"})
 *    }
 * )
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
     * @var GameListGame[]|ArrayCollection
     * @ORM\OneToMany(targetEntity="GameListGame", mappedBy="gameList", cascade={"remove"})
     */
    private $gameListGames;

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
     * @Groups({"gameList"})
     * @var User
     * @ORM\ManyToOne(targetEntity="User", inversedBy="gameLists")
     *
     */
    private User $user;

    public function __construct(int $type, $user)
    {
        $this->gameListGames = new ArrayCollection();
        $this->privacyType = GameListPrivacyType::PRIVATE;
        $this->type = $type;
        $this->name = '';
        $this->user = $user;
    }

    /**
     * @return string
     */
    public function getId(): string
    {
        return $this->id;
    }

    /**
     * @return GameListGame[]|PersistentCollection
     */
    public function getGameListGames()
    {
        return $this->gameListGames;
    }

    /**
     * @param GameListGame $game
     */
    public function addGameListGame(GameListGame $game)
    {
        if (!$this->gameListGames->contains($game)) {
            $this->gameListGames[] = $game;
        }
    }

    /**
     * @param GameListGame $game
     */
    public function removeGameListGame(GameListGame $game)
    {
        if ($this->gameListGames->contains($game)) {
            $this->gameListGames->removeElement($game);
        }
    }

    /**
     * @param GameListGame[]|PersistentCollection $gameListGames
     */
    public function setGameListGames(PersistentCollection $gameListGames): void
    {
        foreach ($gameListGames as $gameListGame) {
            $this->addGameListGame($gameListGame);
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
