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
class AgeRating implements ExternalEntityInterface
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
     * @var string
     * @Groups({"gameLoaded"})
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private ?string $synopsis;

    /**
     * @var int
     * @Groups({"gameLoaded"})
     * @ORM\Column(type="integer", nullable=false)
     */
    private int $category;

    /**
     * @var int
     * @Groups({"gameLoaded"})
     * @ORM\Column(type="integer", nullable=false)
     */
    private int $rating;

    /**
     * @var Game
     * @ORM\ManyToOne(targetEntity="App\Entity\Game", inversedBy="ageRatings")
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
     * @return string|null
     */
    public function getSynopsis(): ?string
    {
        return $this->synopsis;
    }

    /**
     * @param string|null $synopsis
     */
    public function setSynopsis(?string $synopsis): void
    {
        $this->synopsis = $synopsis;
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
     * @return int
     */
    public function getRating(): int
    {
        return $this->rating;
    }

    /**
     * @param int $rating
     */
    public function setRating(int $rating): void
    {
        $this->rating = $rating;
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
