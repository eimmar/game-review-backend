<?php

declare(strict_types=1);




namespace App\Service\IGDB\DTO;

class Website
{
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
