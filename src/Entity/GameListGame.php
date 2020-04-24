<?php

/**
 * @copyright C UAB NFQ Technologies
 *
 * This Software is the property of NFQ Technologies
 * and is protected by copyright law – it is NOT Freeware.
 *
 * Any unauthorized use of this software without a valid license key
 * is a violation of the license agreement and will be prosecuted by
 * civil and criminal law.
 *
 * Contact UAB NFQ Technologies:
 * E-mail: info@nfq.lt
 * http://www.nfq.lt
 *
 */

declare(strict_types=1);

namespace App\Entity;

use DateTimeImmutable;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\HasLifecycleCallbacks
 * @ORM\Entity(repositoryClass="App\Repository\GameListGameRepository")
 * @ORM\Table(name="game_game_list")
 */
class GameListGame
{
    /**
     * @ORM\Id()
     * @var GameList
     * @ORM\ManyToOne(targetEntity="App\Entity\GameList", inversedBy="gameListGames", cascade={"persist"})
     */
    private $gameList;

    /**
     * @ORM\Id()
     * @var Game
     * @ORM\ManyToOne(targetEntity="Game", inversedBy="gameListGames")
     */
    private $game;

    /**
     * @var DateTimeImmutable
     * @ORM\Column(type="datetime_immutable", options={"default": "CURRENT_TIMESTAMP"})
     */
    protected $createdAt;

    /**
     * @param GameList $gameList
     * @param Game $game
     */
    public function __construct(GameList $gameList, Game $game)
    {
        $this->gameList = $gameList;
        $this->game = $game;
    }

    /**
     * @return GameList
     */
    public function getGameList(): GameList
    {
        return $this->gameList;
    }

    /**
     * @param GameList $gameList
     */
    public function setGameList(GameList $gameList): void
    {
        $this->gameList = $gameList;
    }

    /**
     * @return Game
     */
    public function getGame(): Game
    {
        return $this->game;
    }

    /**
     * @param Game $game
     */
    public function setGame(Game $game): void
    {
        $this->game = $game;
    }

    /**
     * @return DateTimeImmutable
     */
    public function getCreatedAt(): DateTimeImmutable
    {
        return $this->createdAt;
    }

    /**
     * @param DateTimeImmutable $createdAt
     */
    public function setCreatedAt(DateTimeImmutable $createdAt): void
    {
        $this->createdAt = $createdAt;
    }

    /**
     * @ORM\PrePersist
     */
    public function prePersist()
    {
        $this->createdAt = new DateTimeImmutable();
    }
}
