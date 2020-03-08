<?php

declare(strict_types=1);




namespace App\Service\IGDB\DTO;

use App\Traits\IdentifiableTrait;

class Website
{
    use IdentifiableTrait;

    /**
     * @var int|null
     */
    private $category;

    /**
     * @var Game|int|null
     */
    private $game;

    /**
     * @var bool|null
     */
    private $trusted;

    /**
     * @var string|null
     */
    private $url;

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
