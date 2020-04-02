<?php

declare(strict_types=1);




namespace App\Entity\Game;

use App\Entity\ExternalEntityInterface;
use App\Entity\Game;
use App\Traits\ExternalEntityTrait;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * @ORM\Entity
 */
class Website implements ExternalEntityInterface
{
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
     * @var bool
     * @Groups({"gameLoaded"})
     * @ORM\Column(type="boolean", nullable=false)
     */
    private bool $trusted;

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
     * @var Game
     * @ORM\ManyToOne(targetEntity="App\Entity\Game", inversedBy="websites")
     */
    private Game $game;

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
     * @return bool
     */
    public function isTrusted(): bool
    {
        return $this->trusted;
    }

    /**
     * @param bool $trusted
     */
    public function setTrusted(bool $trusted): void
    {
        $this->trusted = $trusted;
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
}
