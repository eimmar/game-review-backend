<?php

declare(strict_types=1);




namespace App\Service\IGDB\DTO\Game;

use App\Service\IGDB\DTO\Game;
use App\Service\IGDB\DTO\ResponseDTO;
use App\Traits\IdentifiableTrait;

class Website implements ResponseDTO
{
    use IdentifiableTrait;

    /**
     * @var int|null
     */
    private ?int $category;

    /**
     * @var Game|int|null
     */
    private $game;

    /**
     * @var bool|null
     */
    private ?bool $trusted;

    /**
     * @var string|null
     */
    private ?string $url;

    /**
     * @param int $id
     * @param int|null $category
     * @param Game|int|null $game
     * @param bool|null $trusted
     * @param string|null $url
     */
    public function __construct(int $id, ?int $category, $game, ?bool $trusted, ?string $url)
    {
        $this->id = $id;
        $this->category = $category;
        $this->game = $game;
        $this->trusted = $trusted;
        $this->url = $url;
    }

    /**
     * @return int|null
     */
    public function getCategory(): ?int
    {
        return $this->category;
    }

    /**
     * @return Game|int|null
     */
    public function getGame()
    {
        return $this->game;
    }

    /**
     * @return bool|null
     */
    public function getTrusted(): ?bool
    {
        return $this->trusted;
    }

    /**
     * @return string|null
     */
    public function getUrl(): ?string
    {
        return $this->url;
    }
}
