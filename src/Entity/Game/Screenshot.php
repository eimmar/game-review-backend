<?php

declare(strict_types=1);




namespace App\Entity\Game;

use App\Entity\ExternalEntityInterface;
use App\Entity\Game;
use App\Traits\ExternalEntityTrait;
use App\Traits\TimestampableTrait;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * @ORM\Entity
 * @ORM\HasLifecycleCallbacks
 */
class Screenshot implements ExternalEntityInterface
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
     * @ORM\Column(type="string", length=255, nullable=false)
     */
    private string $imageId;

    /**
     * @var string
     * @Groups({"gameLoaded"})
     * @ORM\Column(type="string", length=255, nullable=false)
     */
    private string $url;

    /**
     * @var int
     * @Groups({"gameLoaded"})
     * @ORM\Column(type="integer", nullable=false)
     */
    private int $height;

    /**
     * @var int
     * @Groups({"gameLoaded"})
     * @ORM\Column(type="integer", nullable=false)
     */
    private int $width;

    /**
     * @var Game
     * @ORM\ManyToOne(targetEntity="App\Entity\Game", inversedBy="screenshots")
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
     * @return string
     */
    public function getImageId(): string
    {
        return $this->imageId;
    }

    /**
     * @param string $imageId
     */
    public function setImageId(string $imageId): void
    {
        $this->imageId = $imageId;
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
    public function getHeight(): int
    {
        return $this->height;
    }

    /**
     * @param int $height
     */
    public function setHeight(int $height): void
    {
        $this->height = $height;
    }

    /**
     * @return int
     */
    public function getWidth(): int
    {
        return $this->width;
    }

    /**
     * @param int $width
     */
    public function setWidth(int $width): void
    {
        $this->width = $width;
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
